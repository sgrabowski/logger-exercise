<?php

namespace App\Logger\Target;

class StandardOutput extends OutputTarget
{
    public function handleOutput(string $output): void
    {
        fwrite(STDOUT, $output);
    }
}