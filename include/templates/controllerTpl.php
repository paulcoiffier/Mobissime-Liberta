<?php
/**
 * Author: Paul Coiffier
 * Date: 16/01/2015
 * Default module controller
 */

if (isset($_GET['action']) && in_array($_GET['action'], array('index', 'create', 'read', 'update', 'delete'))) {
    $action = $_GET['action'];
} else {
    $action = "index";
}

$modUtils = new ModuleUtils($entityManager);
$module_name = $module;
$mod = $modUtils->getModuleByName($module_name);

switch ($action) {

    case 'index':

        /** Twig Loader */
        $loader = new Twig_Loader_Filesystem('modules/' . $module_name . '/views');
        $twig = new Twig_Environment($loader, array(
            'cache' => false
        ));

        $arrayWords = $app->getArrayModulesWords();

        /** Twig template to load */
        $template = $twig->loadTemplate('index.twig.html');

        /** Pass vars to Twig */
        echo $template->render(array(
            'module_name' => $module_name,
            'module_description' => $mod->getModDescription(),
            'module_description' => $mod->getModAuthor(),
            'module_content' => 'Your content here',
            'module_words' => $arrayWords[$module_name],
            'app_language' => $app->getAppLanguage()
        ));
        break;

    case 'create':
        echo 'create';
        break;

    case 'read':
        echo 'read';
        break;

    case 'update':
        echo 'update';
        break;

    case 'delete':
        echo 'delete';
        break;
}
?>