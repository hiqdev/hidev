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

/**
 * Handler for CHANGELOG.md file.
 */
class ChangelogHandler extends BaseHandler
{
    public function parse($text)
    {
        return ['history' => $this->goal->config->commits->history];
    }

    public function render($data)
    {
        $res = CommitsHandler::renderHeader('changelog');

        foreach ($data['history'] as $tag => $notes) {
            $tag = CommitsHandler::arrayPop($notes, 'tag') ?: $tag;
            $new = CommitsHandler::arrayPop($notes, '');
            $res .= CommitsHandler::renderTag($tag);
            foreach ($notes as $note => $cs) {
                $note = CommitsHandler::arrayPop($cs, 'note');
                $res .= CommitsHandler::renderNote($note) ?: $note;
            }
        }

        return $res;
    }

}
