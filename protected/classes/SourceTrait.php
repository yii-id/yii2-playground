<?php

namespace app\classes;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\Inflector;

/**
 * Description of SourceTrait
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
trait SourceTrait
{
    private $_rootPaths;

    protected function getRootPaths()
    {
        if ($this->_rootPaths === null) {
            $this->_rootPaths = [];
            foreach (Yii::$app->params['markdown.sourcePaths'] as $path => $link) {
                $this->_rootPaths[Yii::getAlias($path)] = $link ? rtrim($link, '/') : false;
            }
            krsort($this->_rootPaths);
        }
        return $this->_rootPaths;
    }

    protected function identifyLinkCode($line, $lines, $current)
    {
        if ($line[0] !== '>' || !isset($line[1]) || $line[1] !== '>' || !isset($line[2])) {
            return false;
        }
        $line = trim(substr($line, 2));
        return preg_match('/^[\w\\\\]+(::(\w+)(\(\))?)?$/', $line) ||
            preg_match('/^@[\w-\/\.]+(#\d+(-\d+)?)?(\s*\|\s*\w+)?$/', $line);
    }

    protected function consumeLinkCode($lines, $current)
    {
        $langMap = [
            'js' => 'javascript',
            'htaccess' => 'apache',
            'md' => 'markdown'
        ];
        $line = trim(substr($lines[$current], 2));
        if (preg_match('/^([\w\\\\]+)(::(\w+)(\(\))?)?$/', $line, $matches)) {
            if (isset($matches[3])) {// method
                $ref = new \ReflectionMethod($matches[1], $matches[3]);
                $label = $matches[1] . '::' . $matches[3] . '()';
            } else {
                $ref = new \ReflectionClass($matches[1]);
                $label = $matches[1];
            }
            $filename = $ref->getFileName();
            $contents = array_slice(file($filename), $ref->getStartLine() - 1, $ref->getEndLine() - $ref->getStartLine()
                + 1);
            return[
                [
                    'linkCode',
                    'content' => implode('', $contents),
                    'language' => 'php',
                    'link' => $filename . '#L' . $ref->getStartLine() . '-L' . $ref->getEndLine(),
                    'label' => $label,
                ],
                $current,
            ];
        }
        if (preg_match('/(@[\w-\/\.]+)(#(\d+)(-(\d+))?)?(\s*\|\s*(\w+))?/', $line, $matches)) {
            $filename = Yii::getAlias($matches[1]);
            if (isset($matches[7])) {
                $lang = $matches[7];
            } else {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $lang = isset($langMap[$ext]) ? $langMap[$ext] : $ext;
            }
            if (!empty($matches[3])) {
                $length = empty($matches[5]) ? 1 : $matches[5] - $matches[3] + 1;
                $contents = implode('', array_slice(file($filename), $matches[3] - 1, $length));
                $filename .= "#L{$matches[3]}" . empty($matches[5]) ? '' : "-L{$matches[5]}";
            } else {
                $contents = file_get_contents($filename);
            }
            return[
                [
                    'linkCode',
                    'content' => $contents,
                    'language' => $lang,
                    'link' => $filename,
                ],
                $current,
            ];
        }
    }

    protected function renderLinkCode($block)
    {
        $link = $block['link'];
        foreach ($this->getRootPaths() as $path => $github) {
            if (strpos($link, $path . '/') === 0) {
                $link = substr($link, strlen($path) + 1);
                if ($github) {
                    $githubLink = $github . '/' . $link;
                }
            }
        }
        $label = isset($block['label']) ? $block['label'] : $link;
        if (preg_match('/[^\/\\\\]+$/', $label, $match)) {
            $id = Inflector::slug($match[0]);
        } else {
            $id = Inflector::slug($label);
        }
        $header = Html::tag('span', $label . ' ' . Html::a(Html::icon('tag'), '#' . $id, ['class' => 'hashlink']), ['id' => $id]);
        $header .= Html::a(Html::icon('arrow-up'), '#', ['class' => 'tool-link', 'title' => 'go to top']);
        if (isset($githubLink)) {
            $header .= Html::a(Html::icon('eye-open'), $githubLink, ['target' => '_blank',
                    'class' => 'tool-link', 'title' => 'github']);
        }
        return "\n<h3>$header</h3>\n" . $this->renderCode($block);
    }

    abstract protected function renderCode($block);
}
