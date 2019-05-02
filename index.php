<?php
    ini_set('session.cookie_lifetime', 86400);
    ini_set('session.gc_maxlifetime', 86400);
    session_start();
    date_default_timezone_set("America/Sao_Paulo");

    $base_path = rtrim(__DIR__, '/\\').DIRECTORY_SEPARATOR;
    define('BASE_PATH', $base_path);
    define('BASE_URL', "http://".$_SERVER['HTTP_HOST']."/ERP-Pousada/");

    require 'vendor/autoload.php';

    error_reporting(E_ALL);
    ini_set('display_errors',1);
    set_error_handler('Core\Error::errorHandler');
    set_exception_handler('Core\Error::exceptionHandler');

    $core = new Core\Core();
    $core->run();
