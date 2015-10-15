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
use hidev\helpers\Helper;

/**
 * Goal for README.
 */
class ReadmeGoal extends TemplateGoal
{
    public function getTemplate()
    {
        return 'README';
    }

    public function renderH1($title)
    {
        $res = $title . "\n";
        $res .= str_repeat('-', mb_strlen($title, Yii::$app->charset));
        return $res . "\n";
    }

    public function renderText($text)
    {
        $text = trim($text);
        return $text ? "\n$text\n" : '';
    }

    public function renderSection($section, $default = null)
    {
        $file = 'readme/' . str_replace(' ', '', $section);
        $path = Yii::getAlias("@source/docs/$file.md");
        $text = file_exists($path) ? file_get_contents($path) : $this->getSection($file, $default);
        $text = trim($text);

        return $text ? "\n## $section\n\n$text\n" : '';
    }

    public function getSection($file, $default = null)
    {
        $view = Yii::$app->getView();
        $tpl = Helper::file2template($file);
        return $view->existsTemplate($tpl) ? $view->render($tpl, ['config' => $this->config]) : $default;
    }

    public $badges = [
        'packagist.version' => '[![Latest Stable Version](https://poser.pugx.org/{{ vendor/package }}/v/stable.png)](https://packagist.org/packages/{{ vendor/package }})',
        'packagist.total'   => '[![Total Downloads](https://poser.pugx.org/{{ vendor/package }}/downloads.png)](https://packagist.org/packages/{{ vendor/package }})',
        'versioneye.status' => '[![Dependency Status](https://www.versioneye.com/php/{{ vendor:package }}/dev-master/badge.svg)](https://www.versioneye.com/php/{{ vendor:package }}/dev-master)',
    ];

    public function renderBadges()
    {
        $c = $this->config->get('composer.json');
        if (!$c->has('require') && !$c->has('require-dev')) {
            unset($this->badges['versioneye.status']);
        }
        $res = '';
        foreach ($this->badges as $badge) {
            $res .= $this->renderBadge($badge) . "\n";
        }

        return $res ? "\n$res" : '';
    }

    public function renderBadge($badge)
    {
        return strtr($badge, [
            '{{ vendor/package }}' => $this->vendor->name . '/' . $this->package->name,
            '{{ vendor:package }}' => $this->vendor->name . ':' . $this->package->name,
        ]);
    }
}
