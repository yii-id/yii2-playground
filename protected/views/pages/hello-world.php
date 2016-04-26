<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this View */
?>
HTML: Hello World<br>
PHP: <?= 'Hello World'?><br>
<h2>Hello World</h2>
<?= Html::a('Link Ke Demo', ['/site/page','view'=>'hello-world'])?><br>
Contoh Markdown:
<?php
$text = "
> Contoh Quote

* List 1
* List 2
  * Sub List 2.1
  * Sub List 2.2

```javascript
$('#btn').click(function(){
    alert('Klik...');
});
```";

echo Markdown::process($text, 'mdm');