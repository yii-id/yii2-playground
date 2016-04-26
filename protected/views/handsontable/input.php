<?php

use yii\web\View;
use dee\handsontable\Handsontable;

// use yii\helpers\Html;

/* @var $this View */
?>
<?=
Handsontable::widget([
    'clientOptions' => [
        'startCols' => 6,
        'startRows' => 6,
    ]
]);
?>