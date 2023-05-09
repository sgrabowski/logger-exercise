<?php

namespace App\Logger\MetaData;

use App\Logger\Log;

interface Processor
{
    public function process(Log $log): void;
}