<?php

namespace app\classes\widgets;

use Yii;
use yii\base\Widget;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of PageStat
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PageStat extends Widget
{
    public $total = false;
    public $unique = false;
    public $template = '{num} Hit(s)';
    public $options = [];

    public function run()
    {
        if ($this->total) {
            $pageStat = (new Query())
                    ->select(['count' => 'sum([[count]])', 'unique_count' => 'sum([[unique_count]])'])
                    ->from('{{%page_statistic}}')->one();
        } else {
            $route = Yii::$app->controller->actionParams;
            $route[0] = Yii::$app->controller->getRoute();

            $id = md5(serialize($route));
            $pageStat = (new Query())
                    ->select(['count', 'unique_count'])
                    ->from('{{%page_statistic}}')
                    ->where(['id' => $id])->one();
        }
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $n = $pageStat ? number_format($pageStat[$this->unique ? 'unique_count' : 'count']) : 1;
        return Html::tag($tag, str_replace('{num}', $n, $this->template), $options);
    }
}
