<?php

namespace App\Services;

use App\Lib\Crud\ModelFactory;
use App\Lib\Crud\HeaderFactory;
use App\Lib\Crud\ControllerFactory;
use App\Lib\Module\DirectoriesFactory;
use App\Lib\Module\IniFactory;
use App\Lib\Module\I18NFactory;
use App\Lib\Module\RoutesFactory;
use App\Lib\Crud\IndexFactory;
use MyCrm\Modules\MyCrmModules\Lib\ModUtils;
use App\entities\Module;
use Symfony\Component\Validator\Constraints\DateTime;

Class CrudGenerator
{
    private $entity_fields;
    private $entityManager;

    private $module;
    private $module_author;
    private $module_description;
    private $controller;
    private $namespace;
    private $entity;

    public function generateCrud()
    {

        $module = "TestModule";
        $module_author = "Paul Coiffier";
        $module_description = "Paul Coiffier";
        $controller = "BaseController";
        $namespace = "MyCrm\\Modules";
        $entity = "User";

        $errors = array();

        /** Delete existing values (menu and module) to reinstall as  */

        /** Create directories */
        $directories_factory = new DirectoriesFactory();
        $directories_factory->createModuleDirectories($module, $errors);

        /** Create INI file */
        $ini_factory = new IniFactory();
        $ini_factory->createIniFile($module, $module_author, $module_description);

        /** Create languages files */
        $i18n_factory = new I18NFactory();
        $i18n_factory->createI18nFile($module, 'french');
        $i18n_factory->createI18nFile($module, 'english');

        /** Create internationalization entries for entity fields */
        foreach ($this->entity_fields as $field) {
            $i18n_factory->addI18NEntry($field, $field, $module, "french");
            $i18n_factory->addI18NEntry($field, $field, $module, "english");
        }

        /** Create defaut app route */
        $routes_factory = new RoutesFactory();
        $routes_factory->setModule($module);
        $routes_factory->addRoute('index', '/' . strtolower($module), $namespace . "\\" . $module . '\\Controllers\\' . $controller . '::indexAction');
        $routes_factory->writeRoutesYamlFile();

        /** Create Model */
        $factory = new ModelFactory();
        $model = $factory->createModel($namespace, $entity, $module);

        /** Create Controller */
        $factory = new ControllerFactory();
        $factory->setModule($module);
        $factory->setController($controller);
        $factory->setNamespace($namespace);
        $factory->setModel($model);
        $factory->setEntity($entity);
        $factory->createController();

        /** Create Index View */
        $index_factory = new IndexFactory();
        $index_factory->setModule($module);
        $index_factory->setEntityFields($this->entity_fields);
        $index_factory->createTableIndex($entity);

        /** Create Header file */
        $header_factory = new HeaderFactory();
        $header_factory->createHeader($module);

        /** Create module object in database */
        $modUtils = new ModUtils($this->entityManager);

        /** Create module object in database */
        $new_module = new Module();
        $new_module->setModName($module);
        $new_module->setModAuthor($module_author);
        $new_module->setModDescription($module_description);
        $new_module->setModDateInstall(new \DateTime());
        $new_module->setModDirectoryName($module);
        $new_module->setModIfConnexionRequire(true);
        $new_module->setModIsInstalled(false);
        $this->entityManager->persist($new_module);
        $this->entityManager->flush();

        /** Register / install module */
        $modUtils->register_module($new_module);

    }

    /**
     * @return mixed
     */
    public function getEntityFields()
    {
        return $this->entity_fields;
    }

    /**
     * @param mixed $entity_fields
     */
    public function setEntityFields($entity_fields)
    {
        $this->entity_fields = $entity_fields;
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getModuleAuthor()
    {
        return $this->module_author;
    }

    /**
     * @param mixed $module_author
     */
    public function setModuleAuthor($module_author)
    {
        $this->module_author = $module_author;
    }

    /**
     * @return mixed
     */
    public function getModuleDescription()
    {
        return $this->module_description;
    }

    /**
     * @param mixed $module_description
     */
    public function setModuleDescription($module_description)
    {
        $this->module_description = $module_description;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

}