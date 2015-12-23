<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use CantinaPoker\Command\WelcomeCommand;

$console = new Application('Zeeto PHP Practical','0.1.1');
$console->addCommands([
    new WelcomeCommand()
]);
include ('poker.php');
$console->run();
