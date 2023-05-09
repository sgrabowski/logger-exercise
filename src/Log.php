<?php

namespace App\Logger;

class Log
{
    private readonly int $level;
    private readonly string $levelName;
    private readonly string $message;

    /**
     * A set of contextual information provided by the user.
     * Can be anything, but some examples would be Throwable - the cause of the log, additional information
     * that could assist in debugging
     */
    private array $context = [];

    /**
     * A set of meta information such as date, local ip address, etc
     */
    private array $meta = [];

    /**
     * The cause of the log, may be helpful in the debugging process
     */
    private ?\Throwable $cause;

    public function __construct(int $level, string $levelName, string $message, array $context, ?\Throwable $cause)
    {
        $this->level = $level;
        $this->levelName = $levelName;
        $this->message = $message;
        $this->context = $context;
        $this->cause = $cause;
    }

    public function setMetaData(string $key, $data): void
    {
        $this->meta[$key] = $data;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function getCause(): ?\Throwable
    {
        return $this->cause;
    }

    public function getLevelName(): string
    {
        return $this->levelName;
    }
}