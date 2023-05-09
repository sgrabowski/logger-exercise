<?php

namespace App\Logger;

final class LevelDefinitions
{
    /**
     * @var array<int, string>
     *
     * Definitions of levels and their respective names
     */
    private array $levels = [];

    public function define(int $level, string $name): void
    {
        $this->levels[$level] = $name;
    }

    public function levels(): array
    {
        return $this->levels;
    }

    public function isDefined(int $level): bool
    {
        return array_key_exists($level, $this->levels);
    }

    public function name(int $level): string
    {
        return $this->levels[$level];
    }
}