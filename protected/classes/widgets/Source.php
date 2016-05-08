<?php

namespace app\classes\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Markdown;
use yii\helpers\Inflector;
use app\assets\SourceAsset;
use yii\bootstrap\Html;
use yii\caching\FileDependency;

/**
 * Description of Source
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Source extends Widget
{
    protected $github = 'https://github.com/yii-id/yii2-playground/blob/master/';
    protected $rootPath;
    protected $appPath;
    protected $vendorPath;
    protected $mapLanguage = [
        'js' => 'javascript',
        'htaccess' => 'apache',
        'md' => 'markdown'
    ];

    public function init()
    {
        if (!empty(Yii::$app->params['github'])) {
            $this->github = rtrim(Yii::$app->params['github'], '/') . '/';
        }
        $appPath = Yii::getAlias('@app');
        $this->appPath = $appPath . '/';
        $this->rootPath = Yii::getAlias('@root') . '/';
        $this->vendorPath = Yii::getAlias('@vendor') . '/';
    }

    protected function resolveSource($source)
    {
        if (strpos($source, '\\') === false) {
            // file name
            if (($pos = strpos($source, '#')) !== false) {
                // line code
                $line = substr($source, $pos + 1);
                $line = explode('-', $line);
                $source = substr($source, 0, $pos);
            } else {
                $line = [null, null];
            }
            $source = Yii::getAlias($source);
            if (strpos($source, $this->appPath) === 0) {
                $name = substr($source, strlen($this->appPath));
            } elseif (strpos($source, $this->rootPath) === 0) {
                $name = '/' . substr($source, strlen($this->rootPath));
            } else {
                $name = pathinfo($source, PATHINFO_BASENAME);
            }
            $name .= (isset($line[0]) ? '#' . $line[0] : '');
        } else {
            // class name or method
            if (($pos = strpos($source, '::')) === false) {
                // class
                $ref = new \ReflectionClass($source);
                $name = $source;
            } else {
                $source = rtrim($source, '()');
                $part = explode('::', $source);
                $ref = new \ReflectionMethod($part[0], $part[1]);
                $name = $source . '()';
            }
            $source = $ref->getFileName();
            $line = [$ref->getStartLine(), $ref->getEndLine()];
        }
        if (isset($line[0])) {
            $code = explode("\n", file_get_contents($source));
            $code = array_slice($code, $line[0] - 1, isset($line[1]) ? $line[1] - $line[0] + 1 : 1);
            $code = implode("\n", $code);
        } else {
            $code = file_get_contents($source);
        }
        $ext = pathinfo($source, PATHINFO_EXTENSION);
        $lang = isset($this->mapLanguage[$ext]) ? $this->mapLanguage[$ext] : $ext;

        if (strpos($source, $this->rootPath) === 0 && strpos($source, $this->vendorPath) !== 0) {
            $fname = substr($source, strlen($this->rootPath));
            $github = $this->github . $fname;
            if (isset($line[0])) {
                $github .= '#L' . $line[0];
                if (isset($line[1])) {
                    $github .= '-' . $line[1];
                }
            }
        } else {
            $github = null;
        }
        return[$code, $name, $lang, $github];
    }

    protected function renderCode($key, $block)
    {
        if (is_array($block)) {
            list($code, $name, $lang, $github) = $this->resolveSource($block['source']);
            if (isset($block['lang'])) {
                $lang = $block['lang'];
            }
            $text = empty($block['text']) ? '' : "\n{$block['text']}";
            if (isset($block['github'])) {
                $github = $block['github'];
            }
        } else {
            list($code, $name, $lang, $github) = $this->resolveSource($block);
            $text = '';
        }

        $id = is_int($key) ? Inflector::slug($name) : $key;
        $link = Html::a(Html::icon('arrow-up'), '#', ['class' => 'tool-link', 'title' => 'go to top']);
        if (isset($github)) {
            $link .= Html::a(Html::icon('eye-open'), $github, ['target' => '_blank',
                    'class' => 'tool-link', 'title' => 'github']);
        }
        $hashLink = Html::a(Html::icon('tag'), '#' . $id, ['class' => 'hashlink']);
        $name = Html::tag('span', $name . ' ' . $hashLink, ['id' => $id]);
        return <<<CODE
### $name $link $text
```$lang
$code
```
CODE;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $config = Route::get();
        if (empty($config)) {
            return;
        }
        SourceAsset::register($this->getView());

        $cacheKey = [__CLASS__, $config['name']];
        $cache = Yii::$app->getCache();
        if ($cache && ($content = $cache->get($cacheKey)) !== false) {
            return $content;
        }

        $content = [];
        if (isset($config['sourceText'])) {
            $content[] = $config['sourceText'];
        }
        foreach ($config['sources'] as $i => $block) {
            $content[] = $this->renderCode($i, $block);
        }

        $content = Markdown::process(implode("\n", $content));
        if ($cache) {
            $dependency = new FileDependency(['fileName' => $config['file']]);
            $cache->set($cacheKey, $content, 0, $dependency);
        }
        return $content;
    }
}
