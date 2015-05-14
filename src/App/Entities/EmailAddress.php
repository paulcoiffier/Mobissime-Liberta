<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 21/01/2015
 * Time: 22:14
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
 * @Entity @Table(name="emails")
 **/
class EmailAddress
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
    public $email_address;

    /** @Column(type="boolean") * */
    public $email_is_primary;

    /**
     * @ManyToOne(targetEntity="Person", cascade={"persist", "merge"})
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
     * Set email_address
     *
     * @param string $emailAddress
     * @return EmailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->email_address = $emailAddress;

        return $this;
    }

    /**
     * Get email_address
     *
     * @return string 
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * Set email_is_primary
     *
     * @param boolean $emailIsPrimary
     * @return EmailAddress
     */
    public function setEmailIsPrimary($emailIsPrimary)
    {
        $this->email_is_primary = $emailIsPrimary;

        return $this;
    }

    /**
     * Get email_is_primary
     *
     * @return boolean 
     */
    public function getEmailIsPrimary()
    {
        return $this->email_is_primary;
    }



    /**
     * Set person
     *
     * @param \Person $person
     * @return EmailAddress
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
