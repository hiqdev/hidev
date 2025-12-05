<?php

declare(strict_types=1);

namespace hidev\tests\unit\exception;

use hidev\tests\unit\exception\stub\TestException;
use PHPUnit\Framework\TestCase;

class HasContextTest extends TestCase
{
    public function testAddContext(): void
    {
        $e = new TestException('Error');

        $e->addContext(['a' => 1]);
        $e->addContext(['b' => 2]);

        $this->assertSame(['a' => 1, 'b' => 2], $e->getContext());
    }

    public function testGetContext(): void
    {
        $e = new TestException('Error');
        $e->addContext(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $e->getContext());
    }

    public function testMakeCreatesInstanceWithContext(): void
    {
        $e = TestException::make('Something happened', ['key' => 'value']);

        $this->assertInstanceOf(TestException::class, $e);
        $this->assertSame('Something happened', $e->getMessage());
        $this->assertSame(['key' => 'value'], $e->getContext());
    }

    public function testGetContextValueReturnsNestedValue(): void
    {
        $e = new TestException('Error');
        $e->addContext([
            'user' => [
                'id' => 15,
                'profile' => [
                    'email' => 'test@example.com',
                ],
            ],
        ]);

        $this->assertSame(15, $e->getContextValue('user.id'));
        $this->assertSame('test@example.com', $e->getContextValue('user.profile.email'));
    }

    public function testGetContextValueReturnsDefaultWhenMissing(): void
    {
        $e = new TestException('Error');
        $e->addContext(['foo' => 'bar']);

        $this->assertSame('', $e->getContextValue('missing.key'));
    }

    // -----------------------------------------------------
    // getFormattedContext() Tests
    // -----------------------------------------------------

    public function testGetFormattedContextReturnsEmptyStringWhenNoContext(): void
    {
        $e = new TestException('Error');

        $this->assertSame('', $e->getFormattedContext());
    }

    public function testGetFormattedContextFormatsSimpleContext(): void
    {
        $e = new TestException('Error');
        $e->addContext([
            'key' => 'value',
            'number' => 123,
        ]);

        $output = $e->getFormattedContext();

        $this->assertStringContainsString('Context:', $output);
        $this->assertStringContainsString('key: value', $output);
        $this->assertStringContainsString('number: 123', $output);
    }

    public function testGetFormattedContextFormatsArrayValuesAsJson(): void
    {
        $e = new TestException('Error');
        $e->addContext([
            'data' => ['a' => 1, 'b' => 2],
        ]);

        $output = $e->getFormattedContext();

        // Pretty-printed JSON
        $this->assertStringContainsString('"a": 1', $output);
        $this->assertStringContainsString('"b": 2', $output);
    }

    public function testGetFormattedContextIncludesPreviousException(): void
    {
        $previous = new TestException('Previous error');
        $previous->addContext(['prevKey' => 'prevValue']);

        $e = new TestException('Main error', 0, $previous);
        $e->addContext(['key' => 'value']);

        $output = $e->getFormattedContext();

        $this->assertStringContainsString('previousException', $output);
        $this->assertStringContainsString('prevKey', $output);
        $this->assertStringContainsString('prevValue', $output);
    }
}
