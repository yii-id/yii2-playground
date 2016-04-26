<?php
return[
    'author' => 'Misbahul D Munir <misbahuldmunir@gmail.com>',
    'text' => 'Contoh CRUD sederhana dengan jQuery Easyui',
    'url' => ['easyui/index'],
    'sources' => [
        [
            'source' => '@app/migrations/m160414_015201_contact_info.php',
            'text' => "
Untuk inisialisasi tabel. Dari terminal jalakan

```
$ php yii migrate
```
",
        ],
        'app\models\ContactInfo',
        '@app/controllers/EasyuiController.php',
        '@app/views/easyui/index.php',
        '@app/views/easyui/script.js',
    ]
];
