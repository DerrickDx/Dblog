<?php

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

    const USER_ACTION = 'user';
    const POST_ACTION = 'post';
    const COMMENT_ACTION = 'comment';

    const GET = 'get';
    const POST = 'post';

    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';