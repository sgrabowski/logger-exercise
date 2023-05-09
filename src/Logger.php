<?php

namespace App\Logger;

use App\Logger\LevelComparisonStrategy\Strategy;
use App\Logger\MetaData\Processor;
use App\Logger\Target\OutputTarget;

abstract class Logger
{
    private Strategy $comparisonStrategy;
    private LevelDefinitions $levelDefinitions;

    /**
     * @var array<Processor>
     */
    private array $metaProcessors = [];

    /**
     * @var array<OutputTarget>
     */
    private array $outputTargets = [];

    public function __construct(Strategy $comparisonStrategy, LevelDefinitions $levelDefinitions, array $metaProcessors, array $outputTargets)
    {
        $this->comparisonStrategy = $comparisonStrategy;
        $this->levelDefinitions = $levelDefinitions;
        $this->metaProcessors = $metaProcessors;
        $this->outputTargets = $outputTargets;
    }

    protected function log(int $level, string $message, ?array $context, ?\Throwable $cause): void
    {
        if (!$this->levelDefinitions->isDefined($level)) {
            throw new \InvalidArgumentException(
                'Level "'. $level .'" is not defined'
            );
        }

        $log = new Log($level, $this->levelDefinitions->name($level), $message, $context ?? [], $cause);

        foreach ($this->metaProcessors as $processor) {
            $processor->process($log);
        }

        foreach ($this->outputTargets as $outputTarget) {
            $outputTargetMinimumLevel = $outputTarget->getMinimumLoggingLevel();
            if ($this->comparisonStrategy->isHigherOrEqualInHierarchy($level, $outputTargetMinimumLevel)) {
                $outputTarget->output($log);
            }
        }
    }
}