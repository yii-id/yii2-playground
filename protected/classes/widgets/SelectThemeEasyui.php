<?php

namespace app\classes\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\EasyuiAsset;
use yii\base\InvalidParamException;

/**
 * Description of SelectThemeEasyui
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SelectThemeEasyui extends Widget
{
    public $options = [];

    protected function registerScript($baseUrl)
    {
        $url = json_encode(Url::to(['/site/change-theme', 'for' => EasyuiAsset::PROFILE_NAME]));
        $baseUrl = json_encode($baseUrl . '/');
        $id = EasyuiAsset::LINK_ID;
        $js = <<<JS
$('#{$this->options['id']}').change(function () {
    var val = $(this).val();
    $.post($url, {style: val}, function (s) {
        if(s){
            var src = $baseUrl + s + '/easyui.css';
            $('#{$id}').attr('href',src);
        }
    });
});
JS;

        $this->getView()->registerJs($js);
    }

    /**
     * Get list of avaliable style
     * @param string $dir
     * @return array
     * @throws InvalidParamException
     */
    protected function getItems($dir)
    {
        $cache = Yii::$app->getCache();
        if ($cache && ($items = $cache->get(__METHOD__)) !== false) {
            return $items;
        }

        $items = [];
        $handle = opendir($dir);
        if ($handle === false) {
            throw new InvalidParamException("Unable to open directory: $dir");
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..' || $file === 'icons') {
                continue;
            }
            if (is_dir($dir . '/' . $file)) {
                $items[$file] = $file;
            }
        }
        closedir($handle);
        ksort($items);
        if ($cache) {
            $cache->set(__METHOD__, $items);
        }
        return $items;
    }

    public function run()
    {
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        /* @var $asset EasyuiAsset */
        $asset = Yii::$app->getAssetManager()->getBundle(EasyuiAsset::className());
        $this->registerScript($asset->baseUrl . '/themes');
        echo Html::dropDownList('', $asset->style, $this->getItems($asset->basePath . '/themes'), $this->options);
    }
}
