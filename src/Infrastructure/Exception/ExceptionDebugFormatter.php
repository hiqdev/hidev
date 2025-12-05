<?php

declare(strict_types=1);

namespace hidev\Infrastructure\Exception;

use hidev\exception\HasContextInterface;

final class ExceptionDebugFormatter
{
    public function format(\Throwable $e, bool $skipContext = false): array
    {
        $debugInfo = [
            'class' => \get_class($e),
            'message' => $e->getMessage(),
            'thrownAt' => $e->getFile() . ':' . $e->getLine(),
        ];

        if (!$skipContext && $e instanceof HasContextInterface) {
            $debugInfo = array_merge($debugInfo, [
                'context' => $e->getContext(),
            ]);
        }

        if ($root = $e->getPrevious()) {
            $debugInfo['parentException'] = $this->format($root, $skipContext);
        }
        return $debugInfo;
    }
}
