Oleh Misbahul D Munir <misbahuldmunir@gmail.com>

Untuk kompenen menu

>>@app/views/layouts/header.php#42-65|html
Untuk jsnya

>>@app/views/layouts/notif.js
Setelah itu meregister jsnya
```php
/* @var $this View */
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js');
$this->registerJs($this->render('notif.js'), View::POS_END);
```
>>@app/views/pages/contoh-vuejs.php|html

