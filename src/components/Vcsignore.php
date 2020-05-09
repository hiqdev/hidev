<?php
/**
 * Automation tool mixed with code generator for easier continuous development
 *
 * @link      https://github.com/hiqdev/hidev
 * @package   hidev
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2020, HiQDev (http://hiqdev.com/)
 */

namespace hidev\components;

/**
 * VCS ignore component.
 */
class Vcsignore extends File
{
    protected $_items = [
        '/.env'                     => 'local config',
        '.*.swp'                    => 'IDE & OS files',
        '.idea'                     => 'IDE & OS files',
        'nbproject'                 => 'IDE & OS files',
        '.buildpath'                => 'IDE & OS files',
        '.project'                  => 'IDE & OS files',
        '.settings'                 => 'IDE & OS files',
        'Thumbs.db'                 => 'IDE & OS files',
        '.DS_Store'                 => 'IDE & OS files',
        '/lsp'                      => 'IDE & OS files',
    ];

    public function init()
    {
        $this->_path = $this->take('vcs')->ignorefile;
        $this->load();
    }

    /**
     * Load.
     */
    public function load()
    {
        $items = [];
        foreach ($this->take('binaries')->getItems() as $binary) {
            if ($vcsignore = $binary->getVcsignore()) {
                $items[$vcsignore] = 'Binaries';
            }
        }
        unset($items['git.phar']);
        $this->setItems($items);
        $items = $this->getFile()->load() ?: [];
        $this->setItems($items);
    }
}
