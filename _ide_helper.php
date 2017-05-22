<?php

exit("This file should not be included, only analyzed by your IDE");

class Yii extends \yii\BaseYii
{
    /**
     *
     * @var \local\Application
     */
    public static $app;
}

namespace yii\web {

    /**
     * @property \app\classes\TokenManager $tokenManager
     * @property \yii\authclient\Collection $authClientCollection
     * @property \app\classes\Jwt $jwt
     * @property \dee\queue\Queue $queue
     * @property \app\classes\Formatter $formatter
     * @property \app\classes\Notification $notification
     * @property \app\classes\Firebase $firebase
     */
    class Application extends \yii\base\Application
    {
        public function handleRequest($request)
        {

        }
    }

}
