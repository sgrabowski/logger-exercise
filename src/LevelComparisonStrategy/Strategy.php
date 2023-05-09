<?php

namespace App\Logger\LevelComparisonStrategy;

/**
 * Allows to define logging levels in ascending or descending order
 */
interface Strategy
{
    /**
     * Checks if $compared is higher or equal in the level hierarchy than $reference
     *
     * Example: Generally, DEBUG is considered to be lower in the level hierarchy than INFO
     * If we consider DEBUG to be 100 and INFO to be 400,
     * compare(100, 400) should return false (DEBUG is not higher than INFO)
     * compare(100, 100) should return true
     * compare(400, 100) should return true
     *
     * Obviously, in case the hierarchy is descending instead, the 1st and 3rd case will be inversed
     */
    public function isHigherOrEqualInHierarchy(int $compared, int $reference): bool;
}