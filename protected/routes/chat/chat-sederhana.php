<?php
return[
    'author' => 'Misbahul D Munir <misbahuldmunir@gmail.com>',
    'url' => ['chat/index'],
    'sources' => [
        [
            'source' => '@app/migrations/m160305_191634_chat.php',
            'text' => "
Untuk inisialisasi tabel. Dari terminal jalakan

```
$ php yii migrate
```
",
        ],
        'app\controllers\ChatController',
        [
            'source' => '@app/views/chat/index.php',
            'lang' => 'html'
        ],
        '@app/views/chat/script.js'
    ]
];
