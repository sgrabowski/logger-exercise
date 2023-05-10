<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Logger\Formatter\Formatter;
use App\Logger\Formatter\LineFormatter;
use App\Logger\LevelComparisonStrategy\AscendingImportance;
use App\Logger\LevelDefinitions;
use App\Logger\Log;
use App\Logger\Logger;
use App\Logger\MetaData\DateTimeProcessor;
use App\Logger\Target\OutputTarget;
use App\Logger\Target\StandardOutput;

class MyCustomOutput extends OutputTarget
{
    protected function handleOutput(string $output): void
    {
        fwrite(STDOUT, '---- THIS GOES SOMEWHERE ELSE ----'.PHP_EOL.$output.PHP_EOL);
    }
}

class MyCustomJsonFormatter implements Formatter
{

    public function format(Log $log): string
    {
        $data = [];
        $data['level'] = $log->getLevel();
        $data['level_mame'] = $log->getLevelName();
        $data['message'] = $log->getMessage();
        $data['context'] = $log->getContext();

        return json_encode($data, JSON_PRETTY_PRINT);
    }
}

class MyLogger extends Logger
{
    public function __construct(array $metaProcessors, array $outputTargets)
    {
        $comparisonStrategy = new AscendingImportance();
        $levelDefinitions = new LevelDefinitions();
        $levelDefinitions->define(100, 'DEBUG');
        $levelDefinitions->define(200, 'INFO');
        $levelDefinitions->define(400, 'WARNING');
        $levelDefinitions->define(500, 'ERROR');

        parent::__construct($comparisonStrategy, $levelDefinitions, $metaProcessors, $outputTargets);
    }

    public function debug(string $message, ?array $context = null, ?\Throwable $cause = null): void
    {
        $this->log(100, $message, $context, $cause);
    }

    public function info(string $message, ?array $context = null, ?\Throwable $cause = null): void
    {
        $this->log(200, $message, $context, $cause);
    }

    public function warning(string $message, ?array $context = null, ?\Throwable $cause = null): void
    {
        $this->log(400, $message, $context, $cause);
    }

    public function error(string $message, ?array $context = null, ?\Throwable $cause = null): void
    {
        $this->log(500, $message, $context, $cause);
    }
}

$logger = new MyLogger(
    [new DateTimeProcessor()],
    [
        new StandardOutput(200, new LineFormatter()),
        new MyCustomOutput(201, new MyCustomJsonFormatter())
    ]
);

$logger->error('I should be able to see this message along with the cause of the error (unless in json)', null, new LogicException('don\'t reinvent the wheel, dummy'));
$logger->warning('I should be able to see this message along with some context', ['user' => 'a6985bd1-1f04-46b8-baf9-ed44aea9d6b6']);
$logger->info('it works!');
$logger->debug('WELL WELL WELL I SHOULD NOT BE ABLE TO SEE THIS, OOPSIE?');