<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Description of EasyuiAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class EasyuiAsset extends AssetBundle
{
    const LINK_ID = 'easyui-asset-link';
    const PROFILE_NAME = 'easyuiTheme';

    public $sourcePath = '@app/assets/easyui';
    public $style;
    public $js = [
        'jquery.easyui.min.js',
    ];
    public $css = [
        'main' => 'themes/metro-blue/easyui.css',
        'themes/icon.css',
        'themes/color.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        parent::init();
        if (empty($this->style)) {
            $this->style = Yii::$app->profile->get(self::PROFILE_NAME) ? : 'metro-blue';
        }
        $this->css['main'] = ["themes/{$this->style}/easyui.css", 'id' => self::LINK_ID];
    }
}
