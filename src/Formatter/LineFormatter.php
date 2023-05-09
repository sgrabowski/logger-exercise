<?php

namespace App\Logger\Formatter;

use App\Logger\Log;

class LineFormatter implements Formatter
{

    public function format(Log $log): string
    {
        $meta = $log->getMeta();
        $dateTimePrefix = '';

        if (array_key_exists('date', $meta) && $meta['date'] instanceof \DateTimeInterface) {
            $dateTimePrefix = '[' . $meta['date']->format('Y-m-d H:i:s') . '] ';
        }

        $line = $dateTimePrefix;
        $line .= '['.$log->getLevelName().'] ';
        $line .= '"'. $log->getMessage() . '" ';
        $line .= '[Context: '. json_encode($log->getContext()) . '] ';

        $cause = $log->getCause();
        if ($cause !== null) {
            $line .= '[Cause: '. $cause::class. ':' .$cause->getMessage() .':'. $cause->getFile() .':'. $cause->getLine() .']';
        }

        return $line.PHP_EOL;
    }
}