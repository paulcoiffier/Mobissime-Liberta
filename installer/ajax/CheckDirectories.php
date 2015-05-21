<?php

$path_system = $_POST['path_system'];

if (is_writable($path_system . "/src/App/Conf/routes.yml")) {
    echo 'true';
} else {
    echo 'false';
}

?>