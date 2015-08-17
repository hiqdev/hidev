<?php

/*
 * HiDev - integrate your development
 *
 * @link      https://hidev.me/
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hidev\goals;

use Yii;

/**
 * Goal for README.
 */
class ReadmeGoal extends TemplateGoal
{
    public function getTemplate()
    {
        return 'README';
    }

    public function renderSection($section, $default = null)
    {
        $file = str_replace(' ','',$section);
        $path = Yii::getAlias("@source/docs/readme/$file.md");
        if (!file_exists($path)) {
            return $default;
        }

        return "\n## $section\n\n" . file_get_contents($path);
    }

    public $badges = [
        'packagist.version' => '[![Latest Stable Version](https://poser.pugx.org/{{ package }}/v/stable.png)](https://packagist.org/packages/{{ package }})',
        'packagist.total'   => '[![Total Downloads](https://poser.pugx.org/{{ package }}/downloads.png)](https://packagist.org/packages/{{ package }})',
    ];

    public function renderBadges()
    {
        $res = '';
        foreach ($this->badges as $badge) {
            $res .= $this->renderBadge($badge) . "\n";
        }

        return $res;
    }

    public function renderBadge($badge)
    {
        return strtr($badge,[
            '{{ package }}' => $this->package->fullName,
        ]);
    }
}
