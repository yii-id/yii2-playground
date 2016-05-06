<?php

use yii\web\View;

//use yii\helpers\Html;

/* @var $this View */
$this->context->layout = false;

echo "<pre>\n";
echo "REQUEST METHOD = " . Yii::$app->getRequest()->getMethod()."\n";
print_r($_SERVER);
echo '</pre>';