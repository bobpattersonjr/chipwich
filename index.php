<?php

require 'config.php';

date_default_timezone_set('America/New_York');

// Also spl_autoload_register (Take a look at it if you like)
function __autoload($class) {
	if(file_exists(LIBS . $class .".php")) require LIBS . $class .".php";
    elseif(file_exists('model/'.$class . '.php')) include 'model/'.$class . '.php';
}

$db = new database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
global $db;

$db->exec("SET NAMES utf8");
$db->exec("SET CHARACTER SET utf8");

$app = new bootstrap();
