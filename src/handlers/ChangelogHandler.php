<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\handlers;

/**
 * Handler for CHANGELOG.md file.
 */
class ChangelogHandler extends BaseHandler
{
    public function parsePath($text)
    {
        /// do nothing
    }

    public function render($data)
    {
        $res = CommitsHandler::renderHeader('changelog');

        foreach ($this->goal->getConfig()->commits->getHistory() as $tag => $notes) {
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
