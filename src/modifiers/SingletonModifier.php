<?php

namespace hidev\modifiers;

abstract class SingletonModifier implements ModifierInterface
{
    static protected $_instance;

    public static function getInstance()
    {
        if (static::$_instance === null) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    public static function create()
    {
        return static::getInstance();
    }

    abstract public function modify($command);
}
