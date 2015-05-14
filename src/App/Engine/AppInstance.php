<?php

/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 24/01/2015
 * Time: 00:28
 * Application Singleton
 */

namespace App\Engine;

class AppInstance
{

    private static $_instance = null;


    private $_app_language = '';
    private $_array_words = '';
    private $_array_modules_words = '';
    private $_entityManager;

    private function __construct($app_language, $entityManager)
    {

        $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;

        $this->_app_language = $app_language;
        $this->_entityManager = $entityManager;
        $this->_array_words = parse_ini_file($serverRoot.'/i18n/' . $app_language . '.ini');

        /** Load ini file for each module in a global array */
        $words = array();
        $moduleRepository = $this->_entityManager->getRepository('App\Entities\Module');
        $modules = $moduleRepository->findAll();
        foreach ($modules as $module) {
            $words[$module->getModName()] = parse_ini_file($serverRoot.'src/MyCrm/Modules/' . $module->getModName() . '/i18n/' . $app_language . '.ini');
        }
        $this->_array_modules_words = $words;
    }

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return Singleton
     */
    public static function getInstance($app_language, $entityManager)
    {

        /*
         * Create words array from language
         */
        if (is_null(self::$_instance)) {
            self::$_instance = new AppInstance($app_language, $entityManager);
        }

        return self::$_instance;
    }

    public function getAppLanguage()
    {
        return $this->_app_language;
    }

    public function getArrayWords()
    {
        return $this->_array_words;
    }

    public function getArrayModulesWords()
    {
        return $this->_array_modules_words;
    }
}

?>
