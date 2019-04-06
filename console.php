<?php
require_once 'vendor/autoload.php';
use Symfony\Component\Console\Application;
use BattleSimulator\Console\Command\BattleCommand;

$application = new Application();
$application->add(new BattleCommand());
$application->run();