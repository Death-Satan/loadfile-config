<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$config = new \DeathSatan\LoadfileConfig\Config();
$dir = __DIR__.DIRECTORY_SEPARATOR;
$config->load($dir.'aaa.php');
$config->load($dir.'test.ini');
$config->load($dir.'demo.yaml');
var_dump($config->get());