<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * 
 */
class AdminLteAsset extends AssetBundle
{
    //change source location
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css = [
        'css/skins/_all-skins.min.css',
        'css/AdminLTE.min.css',
    ];
    public $js = [
        'js/app.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle'
    ];

}
