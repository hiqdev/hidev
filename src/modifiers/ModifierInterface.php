<?php

namespace hidev\modifiers;

interface ModifierInterface
{
    /**
     * Modifies
     * @param mixed $value
     * @return mixed
     */
    public function modify($value);
}
