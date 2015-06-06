<?php

namespace App\Engine;

/**
 * App Instance Singleton
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class AppInstance
{

    /**
     * Singleton instance
     * @var
     */
    private static $_instance = null;

    /**
     * Application language to use
     * @var string
     */
    private $_app_language = '';

    /**
     * Array for application words (translation)
     * @var array
     */
    private $_array_words = '';

    /**
     * Array for modules words (for translation)
     * @var array
     */
    private $_array_modules_words = '';

    /**
     * EntityManager
     * @var Doctrine EntityManager
     */
    private $_entityManager;

    /**
     * Contructor
     *
     * @param string $app_language Language to use
     * @param EntityManager $entityManager Doctrine entity manager
     */
    private function __construct($app_language, $entityManager)
    {

        if($_SERVER['DOCUMENT_ROOT']==null){
            $serverRoot = install_sys_dir;
        } else {
            $serverRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . install_path;
        }


        $this->_app_language = $app_language;
        $this->_entityManager = $entityManager;
        $this->_array_words = parse_ini_file($serverRoot . '/i18n/' . $app_language . '.ini');

        /** Load ini file for each module in a global array */
        $words = array();
        $moduleRepository = $this->_entityManager->getRepository('App\Entities\Module');
        $modules = $moduleRepository->findAll();
        foreach ($modules as $module) {
            $words[$module->getModName()] = parse_ini_file($serverRoot . 'src/MyCrm/Modules/' . $module->getModName() . '/i18n/' . $app_language . '.ini');
        }
        $this->_array_modules_words = $words;
    }

    /**
     * Instanciante if not exist and/or return app instance
     * @param string $app_language Language to use
     * @param EntityManager $entityManager Doctrine entity manager
     * @return Singleton instance
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

    /**
     * Get application language
     * @return string Application language
     */
    public function getAppLanguage()
    {
        return $this->_app_language;
    }

    /**
     * Get application language (for translation)
     * @return array Array with application words (for translation)
     */
    public function getArrayWords()
    {
        return $this->_array_words;
    }

    /**
     * Get modules words (for translation)
     * @return array Array with all modules words (for translation)
     */
    public function getArrayModulesWords()
    {
        return $this->_array_modules_words;
    }
}

?>
