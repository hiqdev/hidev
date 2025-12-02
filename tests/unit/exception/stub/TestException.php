<?php

declare(strict_types=1);

namespace hidev\tests\unit\exception\stub;

use Exception;
use hidev\exception\HasContext;
use hidev\exception\HasContextInterface;

class TestException extends Exception implements HasContextInterface
{
    use HasContext;
}
