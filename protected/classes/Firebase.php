<?php

namespace app\classes;

use Yii;
use yii\httpclient\Client;
use Google\Auth\Credentials\ServiceAccountCredentials;
use yii\web\HttpException;

/**
 * Description of Firebase
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Firebase extends \yii\base\Object
{
    /**
     *
     * @var string
     */
    public $baseUrl;
    /**
     *
     * @var string|array
     */
    public $serviceAccount;
    /**
     *
     * @var array
     */
    public $customAuth;
    /**
     *
     * @var Client
     */
    private $_client;
    /**
     *
     * @var ServiceAccountCredentials
     */
    private $_serviceAccount;
    /**
     *
     * @var Jwt
     */
    private $_jwt;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (is_string($this->serviceAccount)) {
            $this->serviceAccount = Yii::getAlias($this->serviceAccount);
            if (is_file($this->serviceAccount)) {
                $this->serviceAccount = file_get_contents($this->serviceAccount);
            }
            $this->serviceAccount = json_decode($this->serviceAccount, true);
        }
        $scope = [
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/firebase.database'
        ];
        $this->_serviceAccount = new ServiceAccountCredentials($scope, $this->serviceAccount);

        if ($this->baseUrl === null) {
            $this->baseUrl = "https://{$this->serviceAccount['project_id']}.firebaseio.com";
        }
        $this->_client = new Client([
            'baseUrl' => rtrim($this->baseUrl, '/')
        ]);
        $this->_client->on(Client::EVENT_BEFORE_SEND, [$this, 'beforeSend']);
        $this->_jwt = new Jwt([
            'secret' => $this->serviceAccount['private_key'],
            'algorithm' => 'RS256'
        ]);
    }

    /**
     *
     * @param \yii\httpclient\RequestEvent $event
     */
    public function beforeSend($event)
    {
        $request = $event->request;
        $token = $this->_serviceAccount->getLastReceivedToken();
        if ($token === null || $token['expires_at'] < time()) {
            $token = $this->_serviceAccount->fetchAuthToken();
        }
        $request->addHeaders(['Authorization' => 'Bearer ' . $token['access_token']]);
        $url = $request->getUrl();
        if (substr($url[0], -5) !== '.json') {
            $url[0] .= '.json';
        }
        if (!empty($this->customAuth)) {
            $url['auth_variable_override'] = json_encode($this->customAuth);            
        }
        $request->setUrl($url);
    }

    /**
     *
     * @param string $method
     * @param string $location
     * @param array $data
     * @param array $params
     * @return mixed
     */
    public function send($method, $location, $data, $params = [])
    {
        $params[0] = trim($location, '/');
        $request = $this->_client->createRequest()
            ->setMethod($method)
            ->setUrl($params)
            ->setFormat('json')
            ->setData($data);

        $response = $request->send();
        if ($response->getIsOk()) {
            return $response->getData();
        } else {
            throw new HttpException($response->getStatusCode(), $response->data['error']);
        }
    }

    /**
     *
     * @param type $location
     * @param type $query
     * @return mixed
     */
    public function get($location, $query = [])
    {
        return $this->send('get', $location, [], $query);
    }

    /**
     *
     * @param type $location
     * @param type $data
     * @param string $print pretty|silent
     * @return string
     */
    public function push($location, $data, $print = null)
    {
        if ($print) {
            $params = ['print' => $print];
        } else {
            $params = [];
        }
        $result = $this->send('post', $location, $data, $params);
        if (isset($result['name'])) {
            return $result['name'];
        }
        throw new HttpException(412, 'Invalid result');
    }

    /**
     *
     * @param type $location
     * @param type $data
     * @param string $print pretty|silent
     * @return mixed
     */
    public function set($location, $data, $print = null)
    {
        if ($print) {
            $params = ['print' => $print];
        } else {
            $params = [];
        }
        return $this->send('put', $location, $data, $params);
    }

    /**
     *
     * @param string $location
     * @param array $data
     * @param string $print pretty|silent
     * @return mixed
     */
    public function update($location, $data, $print = null)
    {
        if(empty($data)){
            return [];
        }
        $params = $print ? ['print'=>$print] : [];
        return $this->send('patch', $location, $data, $params);
    }

    /**
     *
     * @param type $location
     * @return \yii\httpclient\Response
     */
    public function delete($location)
    {
        return $this->send('delete', $location, null);
    }

    public function customToken($claims = [])
    {
        if (empty($claims['uid']) && Yii::$app->has('user')) {
            $user = Yii::$app->user;
            $claims['uid'] = $user->isGuest ? 'anonimous_' . Yii::$app->profile->id : 'user_' . $user->id;
        }
        $email = $this->serviceAccount['client_email'];
        $time = time();
        $claims = array_merge($claims, [
            "iss" => $email,
            "sub" => $email,
            "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
            'iat' => $time,
            'exp' => $time + 3600,
        ]);
        $token = $this->_jwt->encode($claims);
        return $token;
    }
}
