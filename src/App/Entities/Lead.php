<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 22/01/2015
 * Time: 00:54
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
 * @Entity @Table(name="leads")
 **/
class Lead
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @OneToOne(targetEntity="Person", cascade={"persist", "merge"})
     * @JoinColumn(name="person_id", referencedColumnName="id")
     */
    public $person;




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
     * Set person
     *
     * @param \Person $person
     * @return Lead
     */
    public function setPerson(\App\Entities\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
}
