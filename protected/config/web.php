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
                'pages/<view:[\w\/-]+>' => 'site/page',
                ['class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/product' => 'product-rest',
                    ]
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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'normalizeUserAttributeMap' => [
                        'email' => ['emails', 0, 'value'],
                        'name' => 'displayName',
                        'avatar' => ['image', 'url'],
                    ]
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'normalizeUserAttributeMap' => [
                        'avatar' => function ($attributes){
                            return "https://graph.facebook.com/v2.6/{$attributes['id']}/picture?type=normal";
                        },
                    ]
                ],
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                ],
            ],
        ]
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
