#!/usr/bin/env php
<?php

require_once __DIR__.'/../vendor/autoload.php';

$yml = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__.'/../.travis.yml'));

foreach ($yml['script'] as $testScript) {
    if (false !== strpos($testScript, 'phpunit')) {
        $testScript = str_replace('--coverage-clover var/phpunit/coverage.xml', '', $testScript);
    }

    system($testScript);
}