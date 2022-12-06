#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use DarkaOnLine\AdventOfCode2022\Game2;
use DarkaOnLine\AdventOfCode2022\Game3;
use DarkaOnLine\AdventOfCode2022\Game4;
use DarkaOnLine\AdventOfCode2022\Game5;
use DarkaOnLine\AdventOfCode2022\Game6;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new Game2);
$application->add(new Game3);
$application->add(new Game4);
$application->add(new Game5);
$application->add(new Game6);

$application->run();
