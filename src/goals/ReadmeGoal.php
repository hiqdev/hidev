<?php

/*
 * Task runner, code generator and build tool for easier continuos integration
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (http://hiqdev.com/)
 */

namespace hidev\goals;

use hidev\helpers\Helper;
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

    public function renderBold($text)
    {
        $text = trim($text);

        return $this->renderText('**' . $text . '**');
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
        return $this->getItem('sections') ?: ['Requirements', 'Installation', 'Configuration', 'Basic Usage', 'Usage', 'Support', 'License', 'Acknowledgments'];
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
        'github.version'          => '[![GitHub version](https://badge.fury.io/gh/{{ config.github.vendor }}%2F{{ config.github.package }}.svg)](https://badge.fury.io/gh/{{ config.github.vendor }}%2F{{ config.github.package }})',
        'packagist.stable'        => '[![Latest Stable Version](https://poser.pugx.org/{{ config.composer.fullName }}/v/stable)](https://packagist.org/packages/{{ config.composer.fullName }})',
        'packagist.unstable'      => '[![Latest Unstable Version](https://poser.pugx.org/{{ config.composer.fullName }}/v/unstable)](https://packagist.org/packages/{{ config.composer.fullName }})',
        'packagist.license'       => '[![License](https://poser.pugx.org/{{ config.composer.fullName }}/v/license)](https://packagist.org/packages/{{ config.composer.fullName }})',
        'packagist.downloads'     => '[![Total Downloads](https://poser.pugx.org/{{ config.composer.fullName }}/downloads)](https://packagist.org/packages/{{ config.composer.fullName }})',
        'versioneye.dependencies' => '[![Dependency Status](https://www.versioneye.com/php/{{ config.vendor.name }}:{{ config.package.name }}/dev-master/badge.svg)](https://www.versioneye.com/php/{{ config.vendor.name }}:{{ config.package.name }}/dev-master)',
        'travisci.build'          => '[![Build Status](https://img.shields.io/travis/{{ config.package.fullName }}.svg)](https://travis-ci.org/{{ config.package.fullName }})',
    ];

    public function renderBadges()
    {
        $badges = $this->badges;
        if (!$badges) {
            return '';
        }
        if (!$this->package->getPackageManager()->getConfigFile()->getRequire()) {
            unset($badges['versioneye.dependencies']);
        }
        $res = '';
        foreach ($badges as $badge => $tpl) {
            if (!$tpl) {
                $tpl = $this->known_badges[$badge];
            }
            if ($tpl === 'disabled') {
                continue;
            }
            $res .= $this->renderBadge($tpl) . "\n";
        }

        return $res ? "\n$res" : '';
    }

    public function renderBadge($tpl)
    {
        return $this->getTwig()->render($tpl, ['config' => $this->getConfig()]);
    }

    protected $_twig;

    public function getTwig()
    {
        if ($this->_twig === null) {
            $this->_twig = new \Twig_Environment(new \Twig_Loader_String());
        }

        return $this->_twig;
    }
}
