<?php

namespace app\classes\widgets;

use Yii;
use yii\base\Widget;
use yii\db\Query;

/**
 * Description of PageStat
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PageStat extends Widget
{
    public $options = [];
    public $itemOptions = [];

    public function run()
    {
        $route = Yii::$app->controller->actionParams;
        $route[0] = Yii::$app->controller->getRoute();

        $id = md5(serialize($route));
        $items = [];

        $pageStat = (new Query())
                ->select(['count', 'unique_count'])
                ->from('{{%page_statistic}}')
                ->where(['id' => $id])->one();
        if ($pageStat) {
            $items[] = ['label' => 'Page hit ' . number_format($pageStat['count'])];
            $items[] = ['label' => 'Page unique hit ' . number_format($pageStat['unique_count'])];
        }
        $pageStat = (new Query())
                ->select(['count' => 'sum([[count]])', 'unique_count' => 'sum([[unique_count]])'])
                ->from('{{%page_statistic}}')->one();
        if ($pageStat) {
            $items[] = ['label' => 'Total hit ' . number_format($pageStat['count'])];
            $items[] = ['label' => 'Total unique hit ' . number_format($pageStat['unique_count'])];
        }
        
        return SideNav::widget([
            'options'=>  $this->options,
            'items'=>$items,
        ]);
    }
}
