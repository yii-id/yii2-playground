<?php
return[
    'author' => 'Misbahul D Munir <misbahuldmunir@gmail.com>',
    'text' => 'Contoh export ke csv',
    'url' => ['product/index'],
    'sources' => [
        'app\controllers\ProductController::actionIndex',
        'app\controllers\ProductController::actionExportCsv',
        [
            'source' => '@app/views/product/index.php',
            'lang' => 'html'
        ],
    ]
];
