<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 20/01/2015
 * Time: 01:59
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
 * @Entity @Table(name="modules_actions")
 **/
class ModuleAction {

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
    protected $moa_action_name;

    /**
     * @ManyToOne(targetEntity="Module", cascade={"persist", "merge"})
     * @JoinColumn(name="module_id", referencedColumnName="id", onDelete="CASCADE")
     */
    public $module;

    /**
     * @ManyToOne(targetEntity="Groups", cascade={"persist", "merge"})
     * @JoinColumn(name="groupe_id", referencedColumnName="id")
     */
    public $groupe;

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
     * Set moa_action_name
     *
     * @param string $moaActionName
     * @return ModuleAction
     */
    public function setMoaActionName($moaActionName)
    {
        $this->moa_action_name = $moaActionName;

        return $this;
    }

    /**
     * Get moa_action_name
     *
     * @return string 
     */
    public function getMoaActionName()
    {
        return $this->moa_action_name;
    }

    /**
     * Set module
     *
     * @param \Module $module
     * @return ModuleAction
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
     * Set groupe
     *
     * @param \Groups $groupe
     * @return ModuleAction
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
}
