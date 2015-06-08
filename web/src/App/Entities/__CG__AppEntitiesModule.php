<?php

namespace App\Entities\__CG__\App\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Module extends \App\Entities\Module implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array('mod_name' => NULL, 'mod_description' => NULL, 'mod_directory_name' => NULL, 'mod_author' => NULL, 'mod_is_installed' => NULL, 'mod_date_install' => NULL, 'mod_if_connexion_require' => NULL, 'mod_icon' => NULL, 'mod_route' => NULL, 'modules_actions' => NULL);



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {
        unset($this->mod_name, $this->mod_description, $this->mod_directory_name, $this->mod_author, $this->mod_is_installed, $this->mod_date_install, $this->mod_if_connexion_require, $this->mod_icon, $this->mod_route, $this->modules_actions);

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * 
     * @param string $name
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->__getLazyProperties())) {
            $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', array($name));

            return $this->$name;
        }

        trigger_error(sprintf('Undefined property: %s::$%s', __CLASS__, $name), E_USER_NOTICE);
    }

    /**
     * 
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->__getLazyProperties())) {
            $this->__initializer__ && $this->__initializer__->__invoke($this, '__set', array($name, $value));

            $this->$name = $value;

            return;
        }

        $this->$name = $value;
    }

    /**
     * 
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        if (array_key_exists($name, $this->__getLazyProperties())) {
            $this->__initializer__ && $this->__initializer__->__invoke($this, '__isset', array($name));

            return isset($this->$name);
        }

        return false;
    }

    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'mod_name', 'mod_description', 'mod_directory_name', 'mod_author', 'mod_is_installed', 'mod_date_install', 'mod_if_connexion_require', 'mod_icon', 'mod_route', 'modules_actions');
        }

        return array('__isInitialized__', 'id');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Module $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

            unset($this->mod_name, $this->mod_description, $this->mod_directory_name, $this->mod_author, $this->mod_is_installed, $this->mod_date_install, $this->mod_if_connexion_require, $this->mod_icon, $this->mod_route, $this->modules_actions);
        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setModName($modName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModName', array($modName));

        return parent::setModName($modName);
    }

    /**
     * {@inheritDoc}
     */
    public function getModName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModName', array());

        return parent::getModName();
    }

    /**
     * {@inheritDoc}
     */
    public function setModAuthor($modAuthor)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModAuthor', array($modAuthor));

        return parent::setModAuthor($modAuthor);
    }

    /**
     * {@inheritDoc}
     */
    public function getModAuthor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModAuthor', array());

        return parent::getModAuthor();
    }

    /**
     * {@inheritDoc}
     */
    public function setModIsInstalled($modIsInstalled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModIsInstalled', array($modIsInstalled));

        return parent::setModIsInstalled($modIsInstalled);
    }

    /**
     * {@inheritDoc}
     */
    public function getModIsInstalled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModIsInstalled', array());

        return parent::getModIsInstalled();
    }

    /**
     * {@inheritDoc}
     */
    public function setModDateInstall($modDateInstall)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModDateInstall', array($modDateInstall));

        return parent::setModDateInstall($modDateInstall);
    }

    /**
     * {@inheritDoc}
     */
    public function getModDateInstall()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModDateInstall', array());

        return parent::getModDateInstall();
    }

    /**
     * {@inheritDoc}
     */
    public function setModDirectoryName($modDirectoryName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModDirectoryName', array($modDirectoryName));

        return parent::setModDirectoryName($modDirectoryName);
    }

    /**
     * {@inheritDoc}
     */
    public function getModDirectoryName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModDirectoryName', array());

        return parent::getModDirectoryName();
    }

    /**
     * {@inheritDoc}
     */
    public function setModDescription($modDescription)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModDescription', array($modDescription));

        return parent::setModDescription($modDescription);
    }

    /**
     * {@inheritDoc}
     */
    public function getModDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModDescription', array());

        return parent::getModDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setModIfConnexionRequire($modIfConnexionRequire)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModIfConnexionRequire', array($modIfConnexionRequire));

        return parent::setModIfConnexionRequire($modIfConnexionRequire);
    }

    /**
     * {@inheritDoc}
     */
    public function getModIfConnexionRequire()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModIfConnexionRequire', array());

        return parent::getModIfConnexionRequire();
    }

    /**
     * {@inheritDoc}
     */
    public function addModulesAction(\App\Entities\ModuleAction $modulesActions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addModulesAction', array($modulesActions));

        return parent::addModulesAction($modulesActions);
    }

    /**
     * {@inheritDoc}
     */
    public function removeModulesAction(\App\Entities\ModuleAction $modulesActions)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeModulesAction', array($modulesActions));

        return parent::removeModulesAction($modulesActions);
    }

    /**
     * {@inheritDoc}
     */
    public function getModulesActions()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModulesActions', array());

        return parent::getModulesActions();
    }

    /**
     * {@inheritDoc}
     */
    public function setModRoute($modRoute)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModRoute', array($modRoute));

        return parent::setModRoute($modRoute);
    }

    /**
     * {@inheritDoc}
     */
    public function getModRoute()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModRoute', array());

        return parent::getModRoute();
    }

    /**
     * {@inheritDoc}
     */
    public function setModIcon($modIcon)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModIcon', array($modIcon));

        return parent::setModIcon($modIcon);
    }

    /**
     * {@inheritDoc}
     */
    public function getModIcon()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModIcon', array());

        return parent::getModIcon();
    }

}
