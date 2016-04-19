#!/usr/bin/env php
<?php

// Bring in the dependencies
require_once __DIR__."/vendor/autoload.php";

use Monolog\Logger;
use LeeSherwood\Ejabberd\AuthenticationService;
use LeeSherwood\Ejabberd\CommandExecutors\CommandExecutorCollection;

// Setup Logger
$logger = new Logger('ejabberdAuth');

// Create the log handler(s) (lower the logging level for more verbosity)
$syslogHandler = new Monolog\Handler\StreamHandler(fopen("php://stdout","w"));

// Attach the handler
$logger->pushHandler($syslogHandler);

// Create our command collection
$cmdCollection = (new CommandExecutorCollection())->setRequirement(CommandExecutorCollection::REQUIRE_ALL);

// Create our command executors
$cmd1 = new EchoCommandExecutor('Cmd-1');
$cmd2 = new EchoCommandExecutor('Cmd-2');
$cmd3 = new EchoCommandExecutor('Cmd-3');

// My echo command implements the logger aware interface, so i can attach the logger too it
$cmd1->setLogger($logger);
$cmd2->setLogger($logger);
$cmd3->setLogger($logger);

// Push the 3 commands into the collection
$cmdCollection->addCommand($cmd1)->addCommand($cmd2)->addCommand($cmd3);

// Boot the service
$application = new AuthenticationService($logger, $cmdCollection);

// Execute the run loop
$application->run();