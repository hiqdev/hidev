<?php

namespace hidev\modifiers;

class Sudo extends SingletonModifier
{
    public function modify($command)
    {
        return 'sudo ' . $command;
    }
}
