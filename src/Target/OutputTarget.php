<?php

namespace App\Logger\Target;

use App\Logger\Formatter\Formatter;
use App\Logger\Log;

abstract class OutputTarget
{
    private int $minimumLoggingLevel;
    private Formatter $formatter;

    public function __construct(int $minimumLoggingLevel, Formatter $formatter)
    {
        $this->minimumLoggingLevel = $minimumLoggingLevel;
        $this->formatter = $formatter;
    }

    public final function output(Log $log): void
    {
        $this->handleOutput($this->formatter->format($log));
    }

    protected abstract function handleOutput(string $output): void;

    public function getMinimumLoggingLevel(): int
    {
        return $this->minimumLoggingLevel;
    }
}