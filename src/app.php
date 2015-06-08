<?php

include_once('../vendor/twig/twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();

require_once '../bootstrap.php';
require '../src/App/Lib/globalUtils.php';

spl_autoload_register();

use App\Application;
use Symfony\Component\Routing;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\Lib\Login;
use App\Controller;
use App\Engine\AppInstance;
use App\Engine\YamlParser;
use App\Lib\ModuleUtils;

/**
 * Global Application Controller
 * @version 0.1
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */


/**
 * LOGGER Init
 */
$logger = new \Liberta\MLogger\Logger(log_dir);
$logger->setLogLevelThreshold(log_threshold);
$logger->setDateFormat("d/m/Y H:i:s.u");
$logger->logWithClass(LEVEL_INFO, "Init logger", "app");


/** Get connected user or set admin user by default (typically after a fresh installation) */
if (isset($_SESSION['mycrmlogin'])) {
    $username = $_SESSION['mycrmlogin'];
} else {
    $username = "admin";
}

//$entityManager->getMetadataFactory()->getAllMetadata();


/**
 * Container init
 */
$container = new ContainerBuilder();
$container->register('annotationsParser', 'App\Services\AnnotationsParser');
$container->register('CrudGenerator', 'App\Services\CrudGenerator');
//$container->register('liberta.logger', "\Liberta\MLogger\Logger");

$container
    ->register('Logger', 'Liberta\MLogger\Logger')
    ->addArgument(log_dir)
    ->addMethodCall('setLogLevelThreshold', array("log_threshold" => log_threshold))
    ->addMethodCall('setDateFormat', array("date_format" => "d/m/Y H:i:s.u"));


$logger->logWithClass(LEVEL_INFO, "Container initialized", "app");


$login = new Login();

/** YAML Parser declaration */
$yaml = new YamlParser();

/** Get all menus entries*/
$globalUtils = new GlobalUtils($entityManager);
$menus = $globalUtils->getAllMenuEntries();

/*$query = $entityManager->createQuery("select u from App\Entities\User u WHERE u.usr_email = 'admin'");
$query->useResultCache(true);
$query->useQueryCache(true);
$user = $query->getSingleResult();*/
$user = $entityManager->getRepository('App\Entities\User')->findOneBy(array('usr_email' => $username));

/**
 * Module loading
 */
$moduleUtils = new ModuleUtils($entityManager);
$modules = $moduleUtils->getAllModules();


/** Twig Loader*/
$loader = new Twig_Loader_Filesystem(install_sys_dir . '/src/App/Views/');
$twig = new Twig_Environment($loader, array(
    'cache' => true
));

/** Load twig regions includes in MainTpl */
$navBar = $twig->loadTemplate('NavBar.html');
$menuLeft = $twig->loadTemplate('Menu_left.html');

$loader = new Twig_Loader_Filesystem(install_sys_dir . '/src/App/Views/Templates/');
$twig->setLoader($loader);

/** Load twig regions templates */
$headerTpl = $twig->loadTemplate('HeaderTpl.html');
$template = $twig->loadTemplate('MainTpl.html');


/** App conf YAML parsing */
/*$appConfig = array();
$yaml->parseAppConfig($appConfig);
*/

/** Routes */
$routes = new Routing\RouteCollection();

/** Get singleton App instance (for get parameters) */
$app = AppInstance::getInstance($user->getUsrLanguage(), $entityManager);

/** @var  $appParams : Application Parameters */
$appParams = array();
$appParams['user'] = $user;
$appParams['menus'] = $menus;
$appParams['app'] = $app;
$appParams['entityManager'] = $entityManager;
$appParams['navBar'] = $navBar;
$appParams['menuLeft'] = $menuLeft;
$appParams['headerTpl'] = $headerTpl;
$appParams['routes'] = $routes;
$appParams['template'] = $template;
$appParams['container'] = $container;
$appParams['app_language'] = $app->getAppLanguage();

/** Add app conf params */
$appParams['install_path'] = install_path;
$appParams['install_sys_dir'] = install_sys_dir;
$appParams['install_url'] = install_url;

/*** Parse apps routes*/
$app_routes = array();
$yaml->parseAppRoutes($app_routes);

foreach ($app_routes as $route) {
    $route_name = $route['name'];
    $route_path = $route['path'];
    $route_controller = $route['controller'];

    $routes->add($route_name, new Routing\Route($route_path, array(
        'appParams' => $appParams,
        'container' => $container,
        '_controller' => $route_controller
    )));
}

/** Create primary app route */
if ($login->isUserIsLoggedIn()) {
    $routes->add('app', new Routing\Route('/app', array(
        'appParams' => $appParams,
        'container' => $container,
        '_controller' => 'App\\Controller\\AppController::indexAction'
    )));
} else {
    $routes->add('login', new Routing\Route('/app', array(
        'appParams' => $appParams,
        '_controller' => 'App\\Controller\\AppController::LoginAction'
    )));

}

//$modUtils = new ModuleUtils($entityManager);
/** Dynamic routes creation for menus entries */
foreach ($modules as $module) {

    /** Parsing all modules routes */
    $route_array = array();
    $yaml->parseModuleRoutes($module->getModName(), $route_array);

    foreach ($route_array as $route) {
        $route_name = $route['name'];
        $route_path = $route['path'];
        $appParams['module'] = $module;
        $route_controller = $route['controller'];

        $routes->add($route_name, new Routing\Route($route_path, array(
            'appParams' => $appParams,
            'container' => $container,
            '_controller' => $route_controller
        )));
    }
}
return $routes;