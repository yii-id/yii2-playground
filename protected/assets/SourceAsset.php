<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Description of SourceAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SourceAsset extends AssetBundle
{
    const LINK_ID = 'source-asset-link';
    const PROFILE_NAME = 'sourceTheme';

    public $sourcePath = '@vendor/scrivo/highlight.php/styles';
    public $style;

    public function init()
    {
        parent::init();
        if (empty($this->style)) {
            $this->style = Yii::$app->profile->get(self::PROFILE_NAME) ? : 'github';
        }
        $this->css[] = ["{$this->style}.css", 'id' => self::LINK_ID];
    }
}
