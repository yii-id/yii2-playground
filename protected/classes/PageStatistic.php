<?php

namespace app\classes;

use Yii;
use yii\base\ActionFilter;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * Description of PageStatistic
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PageStatistic extends ActionFilter
{

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if (Yii::$app->getRequest()->getIsAjax() && !Yii::$app->getRequest()->getIsPjax()) {
            // if ajax but not pjax
            return $result;
        }
        /* @var $action \yii\base\Action */
        $route = $action->controller->actionParams;
        $route[0] = $action->getUniqueId();
        $id = md5(serialize($route));
        $session = Yii::$app->getSession();

        $url = Url::to($route);
        $title = $action->controller->getView()->title;
        $columns = [
            'url' => $url,
            'page_title' => $title,
            'count' => new Expression('[[count]]+1'),
            'time' => time(),
        ];

        if (!$session->get($id)) {
            $columns['unique_count'] = new Expression('[[unique_count]]+1');
        }
        $command = Yii::$app->getDb()->createCommand();

        // try to update
        if (!$command->update('{{%page_statistic}}', $columns, ['id' => $id])->execute()) {
            // insert new
            $columns = [
                'id' => $id,
                'url' => $url,
                'page_title' => $title,
                'count' => 1,
                'unique_count' => 1,
                'time' => time(),
            ];
            $command->insert('{{%page_statistic}}', $columns)->execute();
        }
        $session->set($id, true);
        return $result;
    }
}
