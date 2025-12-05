<?php

declare(strict_types=1);

namespace hidev\exception;

use hidev\Infrastructure\Exception\ExceptionDebugFormatter;
use Throwable;
use yii\helpers\ArrayHelper;

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

    public function getContextValue(string $fieldName)
    {
        return ArrayHelper::getValue($this->context, $fieldName, '');
    }

    public function getFormattedContext(): string
    {
        $text = '';
        $context = $this->getContext();
        if ($previous = $this->getPrevious()) {
            $context['previousException'] = $this->getExceptionDebugInfo($previous);
        }

        if ($context) {
            $text .= PHP_EOL . PHP_EOL . 'Context:';

            foreach ($context as $key => $value) {
                $stringValue = is_array($value) || is_object($value)
                    ? $this->jsonEncode($value)
                    : trim((string)$value);

                $text .= PHP_EOL . '− ' . $key . ': ' . $stringValue;
            }
        }

        return $text;
    }

    private function getExceptionDebugInfo(?Throwable $throwable): array
    {
        return (new ExceptionDebugFormatter())->format($throwable);
    }

    private function jsonEncode($value): string
    {
        return \json_encode($value, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}
