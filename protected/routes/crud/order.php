<?php
return[
    'author' => 'Misbahul D Munir',
    'text' => 'Contoh penggunaan ext mdmsoft/yii2-widget',
    'url' => ['order/index'],
    'urls' => [
        ['order/view'],
        ['order/create'],
        ['order/update'],
    ],
    'sources' => [
        'app\models\Order',
        'app\models\OrderItem',
        'app\controllers\OrderController::actionCreate()',
        'app\controllers\OrderController::actionUpdate()',
        [
            'source' => '@app/views/order/_form.php',
            'lang' => 'html',
            'text' => 'Untuk detail menggunakan widget `mdm\widgets\GridInput` dari '
            . '[mdmsoft/yii2-widgets](https://github.com/mdmsoft/yii2-widgets)'
        ],
    ],
];
