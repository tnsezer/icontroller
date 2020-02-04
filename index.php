#!/usr/bin/env php
<?php
use Symfony\Component\Console\Application;
use App\Console\Command\PayrollCommand;

$app = new Application();
$app->add(new PayrollCommand());
$app->run();