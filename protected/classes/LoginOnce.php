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

/**
 * Description of LoginOnce
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
            $session = Yii::$app->getSession();
            if ($session->getUseCustomStorage()) {
                if ($session->readSession($sess_id)) {
                    if ($this->throwExeption) {
                        throw new ForbiddenHttpException('Not allowed login more than one');
                    } else {
                        $event->isValid = false;
                    }
                }
            } else {
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
        $this->cache->set([__CLASS__, $user_id], Yii::$app->getSession()->getId());
    }
}
