<?php
return[
    'Site' =>
    [
        'Home' => ['url' => ['site/index']],
        'Statistic' => [
            'url' => ['page-statistic/index'],
            'source' => '@app/routes/page-statistic.md'
        ]
    ],
    'Easyui' => [
        'Crud Sederhana' => [
            'url' => ['easyui/index'],
            'source' => '@app/routes/easyui-crud.md',
        ],
    ],
    'Chat' => [
        'Demo' => [
            'url' => ['chat/index'],
            'source' => '@app/routes/html5sse-chat.md',
        ]
    ],
    'Contoh Sederhana' => [
        'Hello World' => [
            'url' => ['site/page', 'view' => 'hello-world'],
            'source' => '>>@app/views/pages/hello-world.php'
        ],
        'Markdown' => [
            'url' => ['site/page', 'view' => 'markdown-editor'],
            'source' => '@app/routes/markdown-editor.md'
        ],
        'Twig' => [
            'url' => ['site/page', 'view' => 'contoh-twig'],
            'source' => '@app/routes/contoh-twig.md'
        ],
        'Captcha' => [
            'url' => ['site/page', 'view' => 'captcha'],
            'source' => '@app/routes/captcha.md'
        ],
        'Vue JS' => [
            'url' => ['site/page', 'view' => 'contoh-vuejs'],
            'source' => '@app/routes/contoh-vuejs.md'
        ]
    ],
    'CRUD' => [
        'Header Detail' => [
            'url' => ['order/index'],
            'urls' => [
                ['order/view'],
                ['order/create'],
                ['order/update'],
            ],
            'source' => '@app/routes/crud-order.md'
        ],
    ],
    'Export' => [
        'Export To Csv' => [
            'url' => ['product/index'],
            'source' => '@app/routes/contoh-export-csv.md'
        ]
    ],
    'Google Map' => [
        'Imsakiyah' => [
            'url' => ['google-map/index'],
            'source' => '@app/routes/gmap-imsakiyah.md'
        ]
    ],
    'Angularjs' => [
        'Chat' => [
            'url' => ['site/page', 'view' => 'chat-angular'],
            'source' => '@app/routes/angular-chat.md'
        ],
//        'Route' => [
//            'url' => ['site/page', 'view' => 'basic-angular'],
//        ],
    ]
];
