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

    public function renderH($title, $char)
    {
        $res = $title . "\n";
        $res .= str_repeat($char, mb_strlen($title, Yii::$app->charset));
        return $res . "\n";
    }

    public function renderH1($title)
    {
        return $this->renderH($title, '=');
    }

    public function renderH2($title)
    {
        return $this->renderH($title, '-');
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

    public function getSections()
    {
        return $this->getItem('sections') ?: ['Requirements', 'Installation', 'Configuration', 'Usage', 'License', 'Acknowledgments'];
    }

    public function renderSections($sections = null)
    {
        if ($sections === null) {
            $sections = $this->sections;
        }
        $res = '';
        foreach ($sections as $section) {
            $res .= $this->renderSection($section);
        }
        return $res;
    }

    public $known_badges = [
        'github.version'          => '[![GitHub version](https://badge.fury.io/gh/{{ vendor }}%2F{{ package }}.svg)](https://badge.fury.io/gh/{{ vendor }}%2F{{ package }})',
        'packagist.stable'        => '[![Latest Stable Version](https://poser.pugx.org/{{ vendor/package }}/v/stable)](//packagist.org/packages/{{ vendor/package }})',
        'packagist.unstable'      => '[![Latest Unstable Version](https://poser.pugx.org/{{ vendor/package }}/v/unstable)](//packagist.org/packages/{{ vendor/package }})',
        'packagist.license'       => '[![License](https://poser.pugx.org/{{ vendor/package }}/v/license)](//packagist.org/packages/{{ vendor/package }})',
        'packagist.downloads'     => '[![Total Downloads](https://poser.pugx.org/{{ vendor/package }}/downloads)](//packagist.org/packages/{{ vendor/package }})',
        'versioneye.dependencies' => '[![Dependency Status](https://www.versioneye.com/php/{{ vendor:package }}/dev-master/badge.svg)](https://www.versioneye.com/php/{{ vendor:package }}/dev-master)',
    ];

    public function renderBadges()
    {
        $badges = $this->badges;
        if (!$badges) {
            return '';
        }
        $c = $this->config->get('composer.json');
        if (!$c->has('require') && !$c->has('require-dev')) {
            unset($badges['versioneye.dependencies']);
        }
        $res = '';
        foreach ($badges as $badge => $tpl) {
            if (!$tpl) {
                $tpl = $this->known_badges[$badge];
            }
            if ($tpl == 'disabled') {
                continue;
            }
            $res .= $this->renderBadge($tpl) . "\n";
        }

        return $res ? "\n$res" : '';
    }

    public function renderBadge($tpl)
    {
        return strtr($tpl, [
            '{{ vendor }}'         => $this->vendor->name,
            '{{ package }}'        => $this->package->name,
            '{{ vendor/package }}' => $this->vendor->name . '/' . $this->package->name,
            '{{ vendor:package }}' => $this->vendor->name . ':' . $this->package->name,
        ]);
    }
}
