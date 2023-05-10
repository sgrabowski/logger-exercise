<?php

namespace App\Logger\Target;

class StandardOutput extends OutputTarget
{
    protected function handleOutput(string $output): void
    {
        fwrite(STDOUT, $output);
    }
}