<?php

$database_server = $_POST['database_server'];
$database_user = $_POST['database_user'];
$database_password = $_POST['database_password'];
$database_database = $_POST['database_database'];

try {
    $dbh = new PDO('mysql:host=' . $database_server . ';dbname=' . $database_database, $database_user, $database_password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh = null;
    echo "ok";
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>