<?php

use yii\web\View;

//use yii\helpers\Html;

/* @var $this View */
$this->context->layout = false;

//echo "<pre>\n";
//echo "REQUEST METHOD = " . Yii::$app->getRequest()->getMethod() . "\n";
//print_r($_SERVER);
//echo '</pre>';
echo "<pre>\n";
$lines = [
    'Abcd\efgh::test()',
    'Abcde\efgh',
    'Abcd\efgh::test',
    'Aaa\bcde\efgh()',
    'Dggr\Abcde\efgh::',
    '@dded/abcde/fgh | php',
    '@frfr/abce/efg#5|php',
    '@ded/abce/efg#5-7|php',
    '@ab/hdgf/ce/efg#5-7|',
    '@ehry/hfgf/abce/efg#5',
];
foreach ($lines as $line) {
        echo "\n----------\n$line = ";
    if (preg_match('/(@[\w-\/\.]+)(#(\d+)(-(\d+))?)?(\s*\|\s*(\w+))?$/', $line, $matches)) {
        print_r($matches);
        $label = $matches[0];
        if(preg_match('/[^\/\\\\]+$/', $label, $match)){
            print_r($match);
        }
    }
}

echo '</pre>';
