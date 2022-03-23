<?php

function redirect($page){
    header($page);
}

/**
 * Display or remove a message for the result of an action
 * @param $message
 * @param $name
 */
function messageDisplay($message = '', $name = 'msg') {
    if(empty($_SESSION[$name])){
        $_SESSION[$name] = $message;
    } else {
        unset($_SESSION[$name]);
    }
}

/**
 * Check PDO execution successfully or not
 * @param $res
 * @return mixed
 */
function checkExec($res)
{
    return $res['succeeded'];
}

/**
 * Get PDO execution result
 * @param $res
 * @return mixed
 */
function getExecInfo($res)
{
    return $res['info'];
}


/**
 * Check login status of admin users
 * @return bool
 */
function checkLogInStatus(): bool
{
    return isset($_SESSION['user_id']);
}

/** Record last tab action
 * @param $tab
 */
function setTab($tab)
{
    $_SESSION['tab'] = $tab;
}

/**
 * Create session that stores the logged-in user info
 * @param $data
 */
function createUserSession($data)
{
    $_SESSION['user_id'] = $data->id;
    $_SESSION['user_name'] = $data->username;
    $_SESSION['tab'] = USER_ACTION;
}

/**
 * Remove session
 */
function removeUserSession()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['tab']);
    unset($_SESSION['msg']);
}
