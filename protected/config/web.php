<?php
$params = array_merge(
    require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'app\models\ar\User',
            'loginUrl' => ['user/login'],
            'enableAutoLogin' => true,
        ],
        'view' => [
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'Url' => '\yii\helpers\Url',
                        'html' => 'yii\helpers\Html'
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'session' => [
            'class' => 'yii\web\DbSession'
        ],
    ],
    'params' => $params,
];
