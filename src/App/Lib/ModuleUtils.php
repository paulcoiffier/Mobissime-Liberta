<?php

namespace App\Lib;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Module utility class
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class ModuleUtils
{

    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * OBSOLETE : Update all modules
     */
    public function updateModules()
    {
        $path = $_SERVER["DOCUMENT_ROOT"] . install_path . 'modules/';

        foreach (new DirectoryIterator($path) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            /**
             * Load module configuration
             */
            $config = parse_ini_file($path . $fileInfo->getFilename() . '/module.ini');

            /**
             * Check if module is installed
             */
            $moduleRepository = $this->entityManager->getRepository('App\Entities\Module');
            $modules = $moduleRepository->findAll();

            $moduleFind = false;

            echo "Checkin module <strong>" . $config['module_name'] . '</strong>';
            echo "<br />";

            foreach ($modules as $module) {
                if ($module->getModDirectoryName() == $fileInfo->getFilename()) {
                    echo 'Module is in the database<br />';
                    echo 'Module author "' . $config['module_author'] . '<br />';
                    if ($module->getModIsInstalled()) {
                        echo "Module already registered<br />";
                    } else {
                        echo "Module is not registered<br />";
                    }
                    $moduleFind = true;

                    /** Check if connection is required for module usage */
                    if ($config['module_require_login'] == 1) {
                        echo "<strong><i>Connection required</i></strong>";
                        echo '<br />';
                        $module->setModIfConnexionRequire(true);
                    } else {
                        echo "<strong><i>Connection not required</i></strong>";
                        echo '<br />';
                        $module->setModIfConnexionRequire(false);
                    }

                    /**
                     * Register module actions
                     */
                    /** Clean module actions */
                    $modulesActionRepostitory = $this->entityManager->getRepository('App\Entities\ModuleAction');
                    $modules_actions = $modulesActionRepostitory->findBy(array('module' => $module->getId()),
                        array('moa_action_name' => 'asc'));

                    echo "<strong><i>Removing module actions...</i></strong>";
                    echo '<br />';

                    foreach ($modules_actions as $modAction) {
                        $this->entityManager->remove($modAction);
                    }

                    // Insert module actions
                    echo '<strong><i>Processing module actions</i></strong>';
                    echo '<br />';
                    foreach ($config['action'] as $action) {
                        $moduleAction = new ModuleAction();
                        $moduleAction->setModule($module);
                        $moduleAction->setMoaActionName($action);

                        /** Group required for this action */
                        $groupsRepository = $this->entityManager->getRepository('App\Entities\Groups');
                        $groupe = $groupsRepository->findOneBy(array('grp_name' => $config['group.' . $action]));

                        $moduleAction->setGroupe($groupe);

                        $this->entityManager->persist($moduleAction);
                        $this->entityManager->flush();

                    }

                    /**
                     * TODO : Clean/add Menu entries
                     */
                    /*$modulesActionRepostitory = $this->entityManager->getRepository('Menu');
                    $menu_entries = $modulesActionRepostitory->findBy(array('module' => $module->getId()));

                    echo "<strong><i>Removing menu entries</i></strong>";
                    echo '<br />';

                    foreach ($menu_entries as $menuEntry) {
                        $this->entityManager->remove($menuEntry);
                    }*/

                    //echo '<strong><i>Processing menu entries</i></strong>';
                    //echo '<br />';

                    /**
                     * Module is installed
                     */
                    $module->setModIsInstalled(true);

                    $this->entityManager->merge($module);
                    $this->entityManager->flush();
                    break;
                }
            }


            /**
             * Register module in database
             */
            if (!$moduleFind) {
                echo 'Module is not in the database<br />';
                echo 'Module author "' . $config['module_author'] . '<br />';
                $mod = new Module();
                $mod->setModName($config['module_name']);
                $mod->setModDirectoryName($fileInfo->getFilename());
                $mod->setModIsInstalled(0);
                $mod->setModAuthor($config['module_author']);
                $mod->setModDescription($config['module_description']);
                $mod->setModDateInstall(new DateTime());

                /** Check if connection is required for module usage */
                if ($config['module_require_login'] == 1) {
                    echo "<strong><i>Connection required</i></strong>";
                    echo '<br />';
                    $mod->setModIfConnexionRequire(true);
                } else {
                    echo "<strong><i>Connection not required</i></strong>";
                    echo '<br />';
                    $mod->setModIfConnexionRequire(false);
                }

                $this->entityManager->persist($mod);
                $this->entityManager->flush();

                echo "Module registered";
            }
            echo '<br />';
        }
    }

    /**
     * OBSOLETE : Test if all databases modules exists in "modules" directory
     */
    public function cleanModules()
    {
        $moduleRepository = $this->entityManager->getRepository('App\Entities\Module');
        $modules = $moduleRepository->findAll();


        foreach ($modules as $module) {
            $moduleFind = false;
            /**
             * "modules" directory iteration
             */
            $path = $_SERVER["DOCUMENT_ROOT"] . install_path . 'modules/';

            foreach (new DirectoryIterator($path) as $fileInfo) {
                if ($fileInfo->isDot()) continue;

                if ($module->getModDirectoryName() == $fileInfo->getFilename()) {

                    $moduleFind = true;
                    break;
                }
            };
            if ($moduleFind) {
                echo 'Module "' . $module->getModDirectoryName() . '" directory found<br />';
            } else {
                echo '<strong>Module "' . $module->getModDirectoryName() . '" directory not found</strong><br />';
                /**
                 * Delete module entry in database
                 */
                echo 'Deleting database entry for module ' . $module->getModDirectoryName() . '<br />';
                $module = $this->entityManager->getRepository('App\Entities\Module')->findOneBy(array('mod_name' => $module->getModName()));
                $this->entityManager->remove($module);
                $this->entityManager->flush();
            }
        }

        echo '</div></div>';
    }

    /**
     * Get all modules
     * @return array App\Entities\Module
     */
    public function getAllModules()
    {
        return $this->entityManager->getRepository('App\Entities\Module')->findAll();
    }

    /**
     * Find App\Entities\Module by name
     * @param $moduleName Module name
     * @return null|\App\Entities\Module
     */
    public function getModuleByName($moduleName)
    {
        return $this->entityManager->getRepository('App\Entities\Module')->findOneBy(array('mod_name' => $moduleName));
    }

    /**
     * Find App\Entities\Module by Id
     * @param $moduleId Module ID
     * @return null|\App\Entities\Module
     */
    public function getModuleById($moduleId)
    {
        return $this->entityManager->getRepository('App\Entities\Module')->findOneBy(array('id' => $moduleId));
    }
}