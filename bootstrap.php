<?php
/**
 * MyCRM
 * User: Paul
 * Date: 15/01/2015
 * Time: 18:52
 * Doctrine bootstrap file
 */
require_once "vendor/autoload.php";
require "src/App/Conf/Parameters.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/** Get Module List */
/*$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("../modules/"),
    RecursiveIteratorIterator::SELF_FIRST | FilesystemIterator::SKIP_DOTS);*/

//$paths = array("../include/entities");

$i = 0;
/*foreach ($objects as $name => $object) {
    $localPath = str_replace("modules\\", '', $name);

    if ($object->isDir()) {
        $fileName = str_replace("modules\\", '', $name);
        if (($fileName != ".") && ($fileName != "..")) {
            if (is_dir('modules/'.$fileName . "/entities/")) {
                $paths[] = 'modules/'.$fileName . "/entities/";
            }
        }
    }

    $i++;
}*/

$paths[] = "src/App/Entities/";

$classLoader = new \Doctrine\Common\ClassLoader('App\Entities','src/App/Entities');
$classLoader->register();

// , "modules/mycrm_todos/entities"

/** Test for each module if have "entities" directory, and if yes add it to array */
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