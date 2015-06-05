<?php

/*
 * HiDev - integrate your development.
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD 3-clause
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hidev\handlers;

use Yii;

/**
 * Handler for CHANGELOG.md file.
 */
class Changelog extends Base
{
    public function parse($text)
    {
        return ['history' => $this->goal->config->commits->history];
    }

    public function render($data)
    {
        $header = '# ' . $this->goal->package->fullName . " changelog";
        $res .= $header . "\n" . str_repeat('-', mb_strlen($header, Yii::$app->charset)) . "\n";

        foreach ($data['history'] as $tag => $notes) {
            $tag = Commits::arrayPop($notes, 'tag');
            $new = Commits::arrayPop($notes, '');
            $res .= Commits::renderTag($tag);
            foreach ($notes as $note => $cs) {
                $note = Commits::arrayPop($cs, 'note');
                $res .= Commits::renderNote($note);
            }
        }

        return $res;
    }


}
