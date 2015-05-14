<?php
/**
 * MyCRM
 * User: Paul
 * Date: 15/01/2015
 * Time: 18:52
 * Doctrine bootstrap file
 */
require_once "vendor/autoload.php";
require "conf/app.inc.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("include/entities");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver' => database_type,
    'user' => database_user,
    'password' => database_password,
    'dbname' => database_schema,
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);