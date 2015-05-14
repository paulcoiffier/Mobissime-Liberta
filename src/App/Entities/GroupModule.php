<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 20/01/2015
 * Time: 02:00
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
 * @Entity @Table(name="groupes_modules")
 **/
class GroupModule {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @OneToOne(targetEntity="Groups", cascade={"persist", "merge"})
     * @JoinColumn(name="group_id", referencedColumnName="id")
     */
    public $groupe;

    /**
     * @OneToOne(targetEntity="Module", cascade={"persist", "merge"})
     * @JoinColumn(name="module_id", referencedColumnName="id")
     */
    public $module;

    /**
     * @OneToOne(targetEntity="ModuleAction", cascade={"persist", "merge"})
     * @JoinColumn(name="module_action_id", referencedColumnName="id")
     */
    public $action;

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
     * Set groupe
     *
     * @param \Groups $groupe
     * @return GroupModule
     */
    public function setGroupe(\App\Entities\Groups $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Groups 
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set module
     *
     * @param \Module $module
     * @return GroupModule
     */
    public function setModule(\App\Entities\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \Module 
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set action
     *
     * @param \ModuleAction $action
     * @return GroupModule
     */
    public function setAction(\App\Entities\ModuleAction $action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \ModuleAction 
     */
    public function getAction()
    {
        return $this->action;
    }
}
