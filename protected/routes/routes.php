<?php
return[
    'Home' => ['url' => ['site/index']],
    'Easyui' => [
        'Crud Sederhana' => [
            'url' => ['order/index'],
            'urls' => [
                ['order/view'],
                ['order/create'],
                ['order/update'],
            ],
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
    ]
];
