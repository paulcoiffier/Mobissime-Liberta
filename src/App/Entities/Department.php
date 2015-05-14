<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/01/2015
 * Time: 20:57
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
 * @Entity @Table(name="departments")
 **/
class Department
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", length=50) * */
    protected $dep_name;


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
     * Set dep_name
     *
     * @param string $depName
     * @return Department
     */
    public function setDepName($depName)
    {
        $this->dep_name = $depName;

        return $this;
    }

    /**
     * Get dep_name
     *
     * @return string 
     */
    public function getDepName()
    {
        return $this->dep_name;
    }
}
