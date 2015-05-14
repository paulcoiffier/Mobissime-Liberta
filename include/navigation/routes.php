<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/01/2015
 * Time: 15:48
 */

if (isset($_GET['module'])) {
    $module = $_GET['module'];
} else {
    $module = 'base';
}

if (isset($_GET['link'])) {
    $link = $_GET['link'];
} else {
    $link = "";
}


if ($module == 'base') {
    if (file_exists('modules/' . $module . '/index.php')) {
        include 'modules/' . $module . '/index.php';
    } else {
        include 'include/errors/404_widget.html';
    };
} else {
    if (file_exists('modules/' . $module . '/index.php')) {
        include 'modules/' . $module . '/index.php';
    } else {
        include 'include/errors/404_widget.html';
    };
}

if ($link == 'login') {
    if (file_exists('modules/login/index.php')) {
        include 'modules/login/index.php';
    } else {
        include 'include/errors/404_widget.html';
    };
}

if ($link == 'logout') {
    if (file_exists('include/security/logout.php')) {
        include 'include/security/logout.php';
    } else {
        include 'include/errors/404_widget.html';
    };;
}