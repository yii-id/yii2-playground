<?php

namespace app\classes;

use Yii;
use yii\base\Behavior;
use yii\web\User;
use yii\web\UserEvent;
use yii\di\Instance;
use yii\caching\Cache;
use yii\base\NotSupportedException;
use yii\web\ForbiddenHttpException;
use yii\web\Cookie;

/**
 * Description of LoginOnce
 *
 * @property User $owner
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class LoginOnce extends Behavior
{
    /**
     *
     * @var Cache 
     */
    public $cache = 'cache';

    /**
     *
     * @var boolean
     */
    public $throwExeption = true;

    /**
     *
     * @var string
     */
    public $cookieKey = '_d_sessid';

    /**
     *
     * @var boolean
     */
    public $kickLogedUser = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->cache = Instance::ensure($this->cache, Cache::className());
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            User::EVENT_BEFORE_LOGIN => 'beforeLogin',
            User::EVENT_AFTER_LOGIN => 'afterLogin',
        ];
    }

    /**
     * 
     * @param UserEvent $event
     */
    public function beforeLogin($event)
    {
        $user_id = $event->identity->getId();
        if (($sess_id = $this->cache->get([__CLASS__, $user_id])) !== false) {
            if (Yii::$app->getRequest()->getCookies()->getValue($this->cookieKey) == $sess_id) {
                // kalau dari browser yang sama, langsung login
                return;
            }
            $session = Yii::$app->getSession();
            if ($this->kickLogedUser) {
                $session->destroySession($sess_id);
            } elseif ($session->getUseCustomStorage() && $session->readSession($sess_id)) {
                if ($this->throwExeption && !$event->cookieBased) {
                    throw new ForbiddenHttpException('Not allowed login more than one');
                } else {
                    $event->isValid = false;
                }
            } elseif (!$session->getUseCustomStorage()) {
                throw new NotSupportedException('Session not supported');
            }
        }
    }

    /**
     *
     * @param UserEvent $event
     */
    public function afterLogin($event)
    {
        $user_id = $event->identity->getId();
        $sess_id = Yii::$app->getSession()->getId();
        $this->cache->set([__CLASS__, $user_id], $sess_id);
        Yii::$app->getResponse()->getCookies()->add(new Cookie([
            'name' => $this->cookieKey,
            'value' => $sess_id,
            'expire' => time() + 24 * 3600,
        ]));
    }
}
