<?php

use App\Services\MigrationService;
use App\Services\SeederService;

if (!isset($argv[1])) {
    return;
}

require __DIR__ . '/vendor/autoload.php';

$command = $argv[1];

switch ($command) {
    case 'db':
        runMigrateAndSeed();
        break;
    case 'migrate':
        runMigrate();
        break;
    case 'seed':
        runSeed();
        break;
    default:
        unknownCommand();
        break;
}

function runMigrate()
{
    echoCommand("Execute migrate");
    MigrationService::createMigrations();
}

function runSeed()
{
    echoCommand("Execute seeders");
    (new SeederService())->run();
}

function runMigrateAndSeed()
{
    runMigrate();
    runSeed();
}

function unknownCommand()
{
    echoCommand("Unknown command");
}

function echoCommand(string $message)
{
    echo $message;
    echo PHP_EOL;
}
