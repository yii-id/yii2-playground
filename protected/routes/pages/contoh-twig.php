<?php
return[
    'author' => 'Misbahul D Munir <misbahuldmunir@gmail.com>',
    'url' => ['site/page', 'view' => 'contoh-twig'],
    'sources'=>[
        '@app/views/pages/contoh-twig.php',
        [
            'source'=>'@app/views/pages/twig/index.twig',
            'text'=>'Jelaskan padaku, mengapa kode seperti ini tampak lebih menarik?'
        ],
        '@app/views/pages/twig/view.twig',
        '@app/views/pages/twig/form.twig',
    ]
];
