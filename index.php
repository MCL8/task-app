<?php

use components\Router;

require 'vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

define('ROOT', dirname(__FILE__));

$router = new Router();
$router->run();


