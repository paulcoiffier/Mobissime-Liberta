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
 * @Entity @Table(name="contacts")
 **/
class Contact
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /**
     * @OneToOne(targetEntity="Person", cascade={"persist", "merge"})
     * @JoinColumn(name="person_id", referencedColumnName="id")
     */
    public $person;

    /**
     * @ManyToOne(targetEntity="Account", cascade={"persist", "merge"})
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    public $account_id;

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
     * @return Contact
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

    /**
     * Set account_id
     *
     * @param \Account $accountId
     * @return Contact
     */
    public function setAccountId(\App\Entities\Account $accountId = null)
    {
        $this->account_id = $accountId;

        return $this;
    }

    /**
     * Get account_id
     *
     * @return \Account 
     */
    public function getAccountId()
    {
        return $this->account_id;
    }
}
