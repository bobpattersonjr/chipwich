<?php

$use_cdn = false;

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('URL', 'http://'.$_SERVER["SERVER_NAME"].'/');

// Prod URL
define('PROD', 'http://example.com/');

define('LIBS', 'libs/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mvc');
define('DB_USER', 'db_user_name');
define('DB_PASS', 'db_user_password');

define('CLI', !isset($_SERVER['HTTP_USER_AGENT']));


define('AWS_ACCESS_KEY', 'something');
define('AWS_SECRET_KEY', 'something');
define('BUCKET_NAME', 'something');

define('S3URL', 'http://s3.amazonaws.com/'.BUCKET_NAME.'/');

if($use_cdn){
    if(URL == PROD) define('CDNURL', 'http://example.cloudfront.net/image/');
    else            define('CDNURL', 'http://example.cloudfront.net/image/');
}else{
    define('CDNURL', URL.'image/');
}

define('SITE_NAME', 'mvc');
