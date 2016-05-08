<?php

namespace app\classes\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Markdown;

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
        $lines = '';
        if (!empty($config['author'])) {
            $lines .= '## ' . $config['author'] . "\n";
        }
        if (!empty($config['text'])) {
            $lines .= $config['text'];
        }
        return Markdown::process($lines);
    }
}
