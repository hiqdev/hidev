<?php declare(strict_types=1);

namespace hidev\exception;

interface HasContextInterface extends \Throwable
{
    public function addContext(array $data): self;

    public function getContext(): array;

    public function getFormattedContext(): string;
}
