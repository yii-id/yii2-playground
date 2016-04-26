<?php

namespace app\classes;

use DomainException;
use Highlight\Highlighter;

/**
 * Description of ApiMarkdown
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ApiMarkdown extends \cebe\markdown\GithubMarkdown
{
    /**
     * @var Highlighter
     */
    private static $highlighter;

    /**
     * @inheritdoc
     */
    protected function renderCode($block)
    {
        if (self::$highlighter === null) {
            self::$highlighter = new Highlighter();
            self::$highlighter->setAutodetectLanguages([
                'apache', 'nginx',
                'bash', 'dockerfile', 'http',
                'css', 'less', 'scss',
                'javascript', 'json', 'markdown',
                'php', 'sql', 'twig', 'xml',
            ]);
        }
        try {
            if (isset($block['language'])) {
                $result = self::$highlighter->highlight($block['language'], $block['content'] . "\n");
                return "<pre><code class=\"hljs {$result->language} language-{$block['language']}\">{$result->value}</code></pre>\n";
            } else {
                $result = self::$highlighter->highlightAuto($block['content'] . "\n");
                return "<pre><code class=\"hljs {$result->language}\">{$result->value}</code></pre>\n";
            }
        } catch (DomainException $e) {
            echo $e;
            return parent::renderCode($block);
        }
    }
}
