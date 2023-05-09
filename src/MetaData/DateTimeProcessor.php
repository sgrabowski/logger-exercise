<?php

namespace App\Logger\MetaData;

use App\Logger\Log;

class DateTimeProcessor implements Processor
{
    public function process(Log $log): void
    {
        $log->setMetaData('date', new \DateTimeImmutable());
    }
}