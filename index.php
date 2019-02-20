<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('include/autoloader.php');
    require('include/functions.php');

    $api = new \Classes\Api;
    $api->processApi();

?>