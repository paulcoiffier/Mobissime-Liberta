<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 20/01/2015
 * Time: 01:58
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
 * @Entity @Table(name="groups")
 **/
class Groups
{

    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
    public $grp_name;

    /** @Column(type="string") * */
    public $grp_description;


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
     * Set grp_name
     *
     * @param string $grpName
     * @return Groups
     */
    public function setGrpName($grpName)
    {
        $this->grp_name = $grpName;

        return $this;
    }

    /**
     * Get grp_name
     *
     * @return string 
     */
    public function getGrpName()
    {
        return $this->grp_name;
    }

    /**
     * Set grp_description
     *
     * @param string $grpDescription
     * @return Groups
     */
    public function setGrpDescription($grpDescription)
    {
        $this->grp_description = $grpDescription;

        return $this;
    }

    /**
     * Get grp_description
     *
     * @return string 
     */
    public function getGrpDescription()
    {
        return $this->grp_description;
    }
}
