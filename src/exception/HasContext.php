<?php declare(strict_types=1);

namespace hidev\exception;

use Throwable;

trait HasContext
{
    protected array $context = [];

    abstract public function getPrevious(): ?Throwable;

    public function addContext(array $data): self
    {
        $this->context = array_merge($this->context, $data);
        return $this;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public static function make(string $message, array $context): self
    {
        $exception = new static($message);
        $exception->addContext($context);

        return $exception;
    }
}
