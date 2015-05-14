<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 23/01/2015
 * Time: 15:50
 */

if (isset($_GET['module'])) {
    $module = $_GET['module'];
} else {
    $module = 'base';
}

if ($module == 'base') {
    include 'modules/base/navigation/header.php';
} else if ($module != '') {
    if (file_exists('modules/' . $module . '/navigation/header.php')) {
        include 'modules/' . $module . '/navigation/header.php';
    } else {
        include 'include/errors/404_widget.html';
    }

}