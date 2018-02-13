<?php


# dev env
if(true) {
    
    
    
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    ini_set("log_errors", 1);
    
    
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'ticketsys');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('PRODUCTION', false);
    date_default_timezone_set('UTC');
    error_reporting(E_ALL);
    
}
# prod env
else {
    
    
    error_reporting(E_ALL);
    ini_set("display_errors", 0);
    ini_set("display_startup_errors", 0);
    ini_set("log_errors", 1);
    
    
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'ticketsys');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('PRODUCTION', true);
    date_default_timezone_set('UTC');
    error_reporting(E_ALL);
    
}
