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


$paths[] = "src/App/Entities";

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
    'dbname' => database_schema
);


$cache = new \Doctrine\Common\Cache\ArrayCache;

$config = new Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver('src/App/Entities');
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir('src/App/Entities');
$config->setProxyNamespace('App\Entities');
$config->setResultCacheImpl($cache);


// DEV
   // $config->setAutoGenerateProxyClasses(true);

//PROD
    //$config->setAutoGenerateProxyClasses(true);

$entityManager = EntityManager::create($dbParams, $config,null,$cache,null);
//$entityManager->getMetadataFactory()->getAllMetadata();
/*$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null,null,null,null);
$config->setAutoGenerateProxyClasses(true);
$entityManager = EntityManager::create($dbParams, $config);*/
