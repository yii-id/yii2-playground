<?php

namespace app\classes\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Description of Author
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Author extends Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        $config = Route::get();
        if (empty($config)) {
            return;
        }
        
        $author = empty($config['author']) ? '' : Html::tag('h1', 'Oleh: ' . Html::encode($config['author']));
        $description = empty($config['text']) ? '' : Html::tag('small', Html::encode($config['text']));
        return $author . $description;
    }
}
