<?php

namespace app\classes;

/**
 * Description of SmileTrait
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
trait SmileTrait
{
    // http://www.emoji-cheat-sheet.com/graphics/emojis/bowtie.png

    /**
     * Parses an inline code span `` : ``.
     * @marker :
     */
    protected function parseInlineSmile($text)
    {
        if (preg_match('/^:(\w+):/s', $text, $matches)) {
            return [
                [
                    'inlineSmile',
                    $matches[1],
                ],
                strlen($matches[0])
            ];
        }
        return [['text', $text[0]], 1];
    }

    protected function renderInlineSmile($block)
    {
        return "<img style=\"height:24px;\" alt=\"{$block[1]}\" "
        . "src=\"http://www.emoji-cheat-sheet.com/graphics/emojis/{$block[1]}.png\"></img>";
    }
}
