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
//            'as loginOnce' => [
//                'class' => 'app\classes\LoginOnce'
//            ]
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/product' => 'product-rest',
                    ]
                ],
                [
                    'pattern' => 'posts',
                    'route' => 'site/page',
                    'defaults' => [
                        'view' => 'angular-route'
                    ]
                ],
                [
                    'pattern' => 'posts/<_x:.*>',
                    'route' => 'site/page',
                    'defaults' => [
                        'view' => 'angular-route'
                    ]
                ],
                [
                    'pattern' => 'angular-route-basic',
                    'route' => 'site/page',
                    'defaults' => [
                        'view' => 'angular-route-basic'
                    ]
                ],
                [
                    'pattern' => 'angular-route-basic/<_x:.*>',
                    'route' => 'site/page',
                    'defaults' => [
                        'view' => 'angular-route-basic'
                    ]
                ],
                'pages/<view:[\w\/-]+>' => 'site/page',
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
    'as statistic' => [
        'class' => 'app\classes\PageStatistic',
        'except' => [
            'chat/message',
            'site/error',
            'site/captcha',
        ],
    ],
    'params' => $params,
];
