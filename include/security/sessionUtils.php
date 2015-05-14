<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 17/01/2015
 * Time: 01:11
 */

function is_user_logged_in()
{
    if (isset($_SESSION['mycrmlogin'])) {
        if ($_SESSION['mycrmlogin'] != '') {
            return true;
        }
    }
    return false;
}

function start()
{
    if (session_id() === '') {
        if (session_start()) {
            return (mt_rand(0, 4) === 0) ? $this->refresh() : true; // 1/5
        }
    }

    return false;
}

function forget()
{
    if (session_id() === '') {
        return false;
    }

    $_SESSION = [];

    setcookie(
        $this->name, '', time() - 42000,
        $this->cookie['path'], $this->cookie['domain'],
        $this->cookie['secure'], $this->cookie['httponly']
    );

    return session_destroy();
}

function refresh()
{
    return session_regenerate_id(true);
}

function checkTimeOut()
{
    if (!isset($_SESSION['timeout_idle'])) {
        $_SESSION['timeout_idle'] = time() + MAX_IDLE_TIME;
    } else {
        if ($_SESSION['timeout_idle'] < time()) {
            //destroy session
        } else {
            $_SESSION['timeout_idle'] = time() + MAX_IDLE_TIME;
        }
    }

}

