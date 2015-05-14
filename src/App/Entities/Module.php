<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/01/2015
 * Time: 21:58
 */

namespace App\Entities;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Entity @Table(name="modules")
 **/
class Module
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
    public $mod_name;

    /** @Column(type="string") * */
    public $mod_description;

    /** @Column(type="string") * */
    public $mod_directory_name;

    /** @Column(type="string") * */
    public $mod_author;

    /** @Column(type="boolean") * */
    public $mod_is_installed;

    /** @Column(type="datetime", nullable=true) * */
    public $mod_date_install;

    /** @Column(type="boolean") * */
    public $mod_if_connexion_require;

    /** @Column(type="string", nullable=true) * */
    public $mod_icon;

    /** @Column(type="string") * */
    public $mod_route;

    /**
     * @OneToMany(targetEntity="ModuleAction", mappedBy="module", cascade={"persist", "merge"})
     */
    public $modules_actions;


    public function __construct()
    {
        $this->setModIsInstalled(false);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mod_name
     *
     * @param string $modName
     * @return Module
     */
    public function setModName($modName)
    {
        $this->mod_name = $modName;

        return $this;
    }

    /**
     * Get mod_name
     *
     * @return string
     */
    public function getModName()
    {
        return $this->mod_name;
    }

    /**
     * Set mod_author
     *
     * @param string $modAuthor
     * @return Module
     */
    public function setModAuthor($modAuthor)
    {
        $this->mod_author = $modAuthor;

        return $this;
    }

    /**
     * Get mod_author
     *
     * @return string
     */
    public function getModAuthor()
    {
        return $this->mod_author;
    }

    /**
     * Set mod_is_installed
     *
     * @param boolean $modIsInstalled
     * @return Module
     */
    public function setModIsInstalled($modIsInstalled)
    {
        $this->mod_is_installed = $modIsInstalled;

        return $this;
    }

    /**
     * Get mod_is_installed
     *
     * @return boolean
     */
    public function getModIsInstalled()
    {
        return $this->mod_is_installed;
    }

    /**
     * Set mod_date_install
     *
     * @param \DateTime $modDateInstall
     * @return Module
     */
    public function setModDateInstall($modDateInstall)
    {
        $this->mod_date_install = $modDateInstall;

        return $this;
    }

    /**
     * Get mod_date_install
     *
     * @return \DateTime
     */
    public function getModDateInstall()
    {
        return $this->mod_date_install;
    }

    /**
     * Set mod_directory_name
     *
     * @param string $modDirectoryName
     * @return Module
     */
    public function setModDirectoryName($modDirectoryName)
    {
        $this->mod_directory_name = $modDirectoryName;

        return $this;
    }

    /**
     * Get mod_directory_name
     *
     * @return string
     */
    public function getModDirectoryName()
    {
        return $this->mod_directory_name;
    }

    /**
     * Set mod_description
     *
     * @param string $modDescription
     * @return Module
     */
    public function setModDescription($modDescription)
    {
        $this->mod_description = $modDescription;

        return $this;
    }

    /**
     * Get mod_description
     *
     * @return string
     */
    public function getModDescription()
    {
        return $this->mod_description;
    }

    /**
     * Set mod_if_connexion_require
     *
     * @param boolean $modIfConnexionRequire
     * @return Module
     */
    public function setModIfConnexionRequire($modIfConnexionRequire)
    {
        $this->mod_if_connexion_require = $modIfConnexionRequire;

        return $this;
    }

    /**
     * Get mod_if_connexion_require
     *
     * @return boolean
     */
    public function getModIfConnexionRequire()
    {
        return $this->mod_if_connexion_require;
    }

    /**
     * Add modules_actions
     *
     * @param \ModuleAction $modulesActions
     * @return Module
     */
    public function addModulesAction(\App\Entities\ModuleAction $modulesActions)
    {
        $this->modules_actions[] = $modulesActions;

        return $this;
    }

    /**
     * Remove modules_actions
     *
     * @param \ModuleAction $modulesActions
     */
    public function removeModulesAction(\App\Entities\ModuleAction $modulesActions)
    {
        $this->modules_actions->removeElement($modulesActions);
    }

    /**
     * Get modules_actions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModulesActions()
    {
        return $this->modules_actions;
    }

    public function setModRoute($modRoute)
    {
        $this->mod_route = $modRoute;

        return $this;
    }

    /**
     * Get mod_route
     *
     * @return string
     */
    public function getModRoute()
    {
        return $this->mod_route;
    }

    public function setModIcon($modIcon)
    {
        $this->mod_icon = $modIcon;

        return $this;
    }

    /**
     * Get mod_icon
     *
     * @return string
     */
    public function getModIcon()
    {
        return $this->mod_icon;
    }
}
