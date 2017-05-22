<?php

namespace app\classes;

use Yii;
use app\models\ar\Auth;
use app\models\ar\User;
use app\models\ar\UserProfile;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * Description of AuthHandler
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    protected $client;
    /**
     * @var array
     */
    protected $attributes;
    /**
     * @var string
     */
    protected $clientId;

    public function __construct(ClientInterface $client, $params = [])
    {
        $this->client = $client;
        $this->clientId = $client->getId();
        $this->attributes = array_merge($params, $client->getUserAttributes());
    }

    /**
     *
     * @return array
     */
    public function handle()
    {
        $attributes = $this->attributes;
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $username = isset($attributes['nickname']) ? $attributes['nickname'] : explode('@', $email)[0];
        if (in_array(strtolower($username), ['admin', 'administrator', 'superadmin', 'super', 'root'])) {
            $username = 'no_' . $username;
        }
        $username = User::getUniqueUsername($username);

        $currentUser = $this->getUser();
        /* @var $auth Auth */
        $auth = Auth::find()->where([
                'source' => $this->clientId,
                'source_id' => $id,
            ])->one();

        if ($currentUser === null) {
            if ($auth) { // login
                /* @var $user User */
                $user = $auth->user;
                $this->updateUserInfo($user);
                $this->login($user);
                return [true, ''];
            } else { // signup
                $user = User::findOne(['email' => $email]);
                if ($user === null) {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'status' => User::STATUS_ACTIVE,
                    ]);
                    $user->generateAuthKey();
                    $isNew = true;
                } else {
                    $user->status = User::STATUS_ACTIVE;
                    $isNew = false;
                }
                $transaction = User::getDb()->beginTransaction();

                if ($user->save() || !$isNew) {
                    $this->updateUserInfo($user);
                    $auth = new Auth([
                        'user_id' => $user->id,
                        'source' => $this->clientId,
                        'source_id' => (string) $id,
                    ]);
                    if ($auth->save(false)) {
                        $transaction->commit();
                        $this->login($user);

                        return [true, Yii::t('app', 'Linked {client} account.', [
                                'client' => $this->client->getTitle()
                        ])];
                    }
                }
                $transaction->rollBack();
                return [false, Yii::t('app', 'Unable to save user: {errors}', [
                        'client' => $this->client->getTitle(),
                        'errors' => json_encode($user->getErrors()),
                ])];
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => $currentUser->id,
                    'source' => $this->clientId,
                    'source_id' => (string) $attributes['id'],
                ]);
                if ($auth->save()) {
                    /* @var $user User */
                    $user = $auth->user;
                    $this->updateUserInfo($user);
                    return [true, Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                    ])];
                }
                return [false, Yii::t('app', 'Unable to link {client} account: {errors}', [
                        'client' => $this->client->getTitle(),
                        'errors' => json_encode($auth->getErrors()),
                ])];
            } elseif ($auth->user_id != $currentUser->id) { // there's existing auth
                return [false, Yii::t('app', 'Unable to link {client} account. There is another user using it.', [
                        'client' => $this->client->getTitle()
                ])];
            }
            return [true, ''];
        }
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        return Yii::$app->getUser()->getIdentity();
    }

    /**
     *
     * @param User $identity
     */
    protected function login($identity)
    {
        Yii::$app->getUser()->login($identity, Yii::$app->params['user.rememberMeDuration']);
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->attributes;
        $profile = $user->profile;
        if ($profile === null) {
            $profile = new UserProfile([
                'id' => $user->id,
                'fullname' => $attributes['name'],
                'avatar' => $attributes['avatar'],
            ]);
            $user->link('profile', $profile);
        } else {
            if ($profile->avatar === null) {
                $profile->avatar = $attributes['avatar'];
                $profile->save();
            }
        }
        $user->synchronToFirebase();
    }
}