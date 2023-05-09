<?php

namespace App\Logger\Formatter;

use App\Logger\Log;

interface Formatter
{
    public function format(Log $log): string;
}