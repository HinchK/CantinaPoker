<?php

require_once 'vendor/autoload.php'; // use path relative to current folder - i.e. ../vendor/autoload.php if you placed it inside /bin

use Symfony\Component\Console\Application;

$console = new Application('Zeeto PHP Practical','0.1.1');
$console->run();
