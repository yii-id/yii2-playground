<?php
Yii::setAlias('@root', dirname(dirname(__DIR__)));
yii\helpers\Markdown::$flavors['mdm'] = [
    'class' => 'app\classes\ApiMarkdown',
    'html5' => true
];
yii\helpers\Markdown::$defaultFlavor = 'mdm';