<?php

namespace app\classes\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Description of Disqus
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Disqus extends Widget
{

    protected function registerScript()
    {
        $config = Route::get();
        $name = Yii::$app->params['disqus.name'];
        $embedScript = "//{$name}.disqus.com/embed.js";
        $countScript = "//{$name}.disqus.com/count.js";

        if ($config) {
            $identifier = $config['name'];
            $url = $config['canonical'];
        } else {
            // not using Url::canonical() to ensure identifier is same when change domain or url rule
            $params = Yii::$app->controller->actionParams;
            $params[0] = '/' . Yii::$app->controller->getRoute();
            $identifier = md5(serialize($params));
            $url = Url::canonical();
        }


        $opts = json_encode([
            'url' => $url,
            'identifier' => $identifier,
            'src' => $embedScript,
        ]);
        $js = <<<JS
(function() {
    var dqOpts = {$opts};
    window.disqus_config = function () {
        this.page.url = dqOpts.url;
        this.page.identifier = dqOpts.identifier;
    };

    var d = document, s = d.createElement('script');
    s.src = dqOpts.src;
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
})();
JS;
        $this->getView()->registerJs($js);
        $this->getView()->registerJsFile($countScript, ['id' => 'dsq-count-scr', 'async' => true]);
    }

    public function run()
    {
        $this->registerScript();
        echo '<div id="disqus_thread"></div>';
    }
}
