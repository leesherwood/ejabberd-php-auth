#!/usr/bin/env php
<?php

// Bring in the dependencies
require_once __DIR__."/vendor/autoload.php";

use Monolog\Logger;
use Tbcdigital\Ejabberd\AuthenticationService;
use Tbcdigital\Ejabberd\CommandExecutors\DummyCommandExecutor;

// Setup Logger
$logger = new Logger('ejabberdAuth');

// Create the log handler(s) (lower the logging level for more verbosity)
$syslogHandler = new Monolog\Handler\SyslogHandler($logger->getName(), LOG_SYSLOG, Logger::DEBUG);

// Attach the handler
$logger->pushHandler($syslogHandler);

// Setup command executor
$executor = new DummyCommandExecutor();

// Boot the service
$application = new AuthenticationService($logger, $executor);

// Execute the run loop
$application->run();