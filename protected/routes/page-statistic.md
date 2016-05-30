## Oleh Misbahul D Munir <misbahuldmunir@gmail.com>

>>@app/migrations/m160530_013610_page_statistic.php
Execute migrate

```
./yii migrate
```
Buat action filter untuk mengupdate conter page.

>>@app/classes/PageStatistic.php
Kemudian attach filter tersebut ke konfig aplikasi

```php
return [

    ...
    'as statistic' => [
        'class' => 'app\classes\PageStatistic',
        'except' => [
            'chat/message',
        ],
    ],
]
```
Sedangkan untuk halaman statistiknya

>>@app/views/page-statistic/index.php|html