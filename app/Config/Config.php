<?php
//    namespace App\Config;
//    echo  __FILE__ . '<br/>';
    const DB_HOST = "db";
    const DB_USER = "root";
    const DB_PASS = "root";
    const DB_NAME = "dblog";

    const VIEW_PATH = __DIR__ . '/../../views';

    define('APP_ROOT', dirname(dirname(__FILE__)));
    const URLROOT = 'http://localhost:8000/';
    const SITENAME = 'DBlog';

    const EXC_MSG_VIEW_NOT_FOUND = 'View not found';
    const EXC_MSG_ROUTE_NOT_FOUND = '404 Not Found';
    const DATE_TIME_FORMAT = 'Y-m-d H:i';