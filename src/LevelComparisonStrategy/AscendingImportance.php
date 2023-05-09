<?php

namespace App\Logger\LevelComparisonStrategy;

class AscendingImportance implements Strategy
{
    public function isHigherOrEqualInHierarchy(int $compared, int $reference): bool
    {
        return $compared >= $reference;
    }
}