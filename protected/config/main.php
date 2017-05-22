<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset'
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'profile' => [
            'class' => 'dee\tools\State'
        ],
        'firebase' => [
            'class' => 'app\classes\Firebase',
            'customAuth' => ['provider' => 'server']
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
];
