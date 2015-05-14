<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 28/01/2015
 * Time: 00:52
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
 * @Entity @Table(name="widgets")
 **/
class Widget
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", nullable=false) * */
    public $wid_name;

    /** @Column(type="string", nullable=false) * */
    public $wid_fileName;

    /** @Column(type="text", nullable=true) * */
    public $wid_description;

    /**
     * @ManyToOne(targetEntity="Module", cascade={"persist", "merge"})
     * @JoinColumn(name="module_id", referencedColumnName="id", onDelete="CASCADE")
     */
    public $module;


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
     * Set wid_name
     *
     * @param string $widName
     * @return Widget
     */
    public function setWidName($widName)
    {
        $this->wid_name = $widName;

        return $this;
    }

    /**
     * Get wid_name
     *
     * @return string 
     */
    public function getWidName()
    {
        return $this->wid_name;
    }

    /**
     * Set wid_fileName
     *
     * @param string $widFileName
     * @return Widget
     */
    public function setWidFileName($widFileName)
    {
        $this->wid_fileName = $widFileName;

        return $this;
    }

    /**
     * Get wid_fileName
     *
     * @return string 
     */
    public function getWidFileName()
    {
        return $this->wid_fileName;
    }

    /**
     * Set module
     *
     * @param \Module $module
     * @return Widget
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
     * Set wid_description
     *
     * @param string $widDescription
     * @return Widget
     */
    public function setWidDescription($widDescription)
    {
        $this->wid_description = $widDescription;

        return $this;
    }

    /**
     * Get wid_description
     *
     * @return string 
     */
    public function getWidDescription()
    {
        return $this->wid_description;
    }
}
