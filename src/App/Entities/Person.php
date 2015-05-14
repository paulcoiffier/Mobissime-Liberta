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
 * @Entity @Table(name="person")
 **/
class Person
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", length=50) * */
    public $person_first_name;

    /** @Column(type="string", length=50) * */
    public $person_last_name;

    /** @Column(type="string", length=5) * */
    public $person_title;

    /** @Column(type="string", length=20, nullable=true) * */
    public $person_phone_office;

    /** @Column(type="string", length=20, nullable=true) * */
    public $person_phone_mobile;

    /** @Column(type="string", length=20, nullable=true) * */
    public $person_fax;

    /** @Column(type="string", length=50, nullable=true) * */
    public $person_street;

    /** @Column(type="string", length=60, nullable=true) * */
    public $person_city;

    /** @Column(type="string", length=10, nullable=true) * */
    public $person_postal_code;

    /** @Column(type="string", length=50, nullable=true) * */
    public $person_country;

    /** @Column(type="string", length=50, nullable=true) * */
    public $person_state;

    /** @Column(type="text", nullable=true) * */
    public $person_description;

    /** @Column(type="boolean", nullable=true) * */
    public $person_sync_to_outlook;

    /** @Column(type="boolean", nullable=true) * */
    public $person_is_account;

    /** @Column(type="boolean", nullable=true) * */
    public $person_is_contact;

    /** @Column(type="boolean", nullable=true) * */
    public $person_is_lead;

    /**
     * @ManyToOne(targetEntity="Account", cascade={"persist", "merge"})
     * @JoinColumn(name="account_user_id", referencedColumnName="id", nullable=true)
     */
    private $person_account;

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
     * Set person_first_name
     *
     * @param string $personFirstName
     * @return Person
     */
    public function setPersonFirstName($personFirstName)
    {
        $this->person_first_name = $personFirstName;

        return $this;
    }

    /**
     * Get person_first_name
     *
     * @return string 
     */
    public function getPersonFirstName()
    {
        return $this->person_first_name;
    }

    /**
     * Set person_last_name
     *
     * @param string $personLastName
     * @return Person
     */
    public function setPersonLastName($personLastName)
    {
        $this->person_last_name = $personLastName;

        return $this;
    }

    /**
     * Get person_last_name
     *
     * @return string 
     */
    public function getPersonLastName()
    {
        return $this->person_last_name;
    }

    /**
     * Set person_title
     *
     * @param string $personTitle
     * @return Person
     */
    public function setPersonTitle($personTitle)
    {
        $this->person_title = $personTitle;

        return $this;
    }

    /**
     * Get person_title
     *
     * @return string 
     */
    public function getPersonTitle()
    {
        return $this->person_title;
    }

    /**
     * Set person_phone_office
     *
     * @param string $personPhoneOffice
     * @return Person
     */
    public function setPersonPhoneOffice($personPhoneOffice)
    {
        $this->person_phone_office = $personPhoneOffice;

        return $this;
    }

    /**
     * Get person_phone_office
     *
     * @return string 
     */
    public function getPersonPhoneOffice()
    {
        return $this->person_phone_office;
    }

    /**
     * Set person_phone_mobile
     *
     * @param string $personPhoneMobile
     * @return Person
     */
    public function setPersonPhoneMobile($personPhoneMobile)
    {
        $this->person_phone_mobile = $personPhoneMobile;

        return $this;
    }

    /**
     * Get person_phone_mobile
     *
     * @return string 
     */
    public function getPersonPhoneMobile()
    {
        return $this->person_phone_mobile;
    }

    /**
     * Set person_fax
     *
     * @param string $personFax
     * @return Person
     */
    public function setPersonFax($personFax)
    {
        $this->person_fax = $personFax;

        return $this;
    }

    /**
     * Get person_fax
     *
     * @return string 
     */
    public function getPersonFax()
    {
        return $this->person_fax;
    }

    /**
     * Set person_street
     *
     * @param string $personStreet
     * @return Person
     */
    public function setPersonStreet($personStreet)
    {
        $this->person_street = $personStreet;

        return $this;
    }

    /**
     * Get person_street
     *
     * @return string 
     */
    public function getPersonStreet()
    {
        return $this->person_street;
    }

    /**
     * Set person_city
     *
     * @param string $personCity
     * @return Person
     */
    public function setPersonCity($personCity)
    {
        $this->person_city = $personCity;

        return $this;
    }

    /**
     * Get person_city
     *
     * @return string 
     */
    public function getPersonCity()
    {
        return $this->person_city;
    }

    /**
     * Set person_postal_code
     *
     * @param string $personPostalCode
     * @return Person
     */
    public function setPersonPostalCode($personPostalCode)
    {
        $this->person_postal_code = $personPostalCode;

        return $this;
    }

    /**
     * Get person_postal_code
     *
     * @return string 
     */
    public function getPersonPostalCode()
    {
        return $this->person_postal_code;
    }

    /**
     * Set person_country
     *
     * @param string $personCountry
     * @return Person
     */
    public function setPersonCountry($personCountry)
    {
        $this->person_country = $personCountry;

        return $this;
    }

    /**
     * Get person_country
     *
     * @return string 
     */
    public function getPersonCountry()
    {
        return $this->person_country;
    }

    /**
     * Set person_state
     *
     * @param string $personState
     * @return Person
     */
    public function setPersonState($personState)
    {
        $this->person_state = $personState;

        return $this;
    }

    /**
     * Get person_state
     *
     * @return string 
     */
    public function getPersonState()
    {
        return $this->person_state;
    }

    /**
     * Set person_description
     *
     * @param string $personDescription
     * @return Person
     */
    public function setPersonDescription($personDescription)
    {
        $this->person_description = $personDescription;

        return $this;
    }

    /**
     * Get person_description
     *
     * @return string 
     */
    public function getPersonDescription()
    {
        return $this->person_description;
    }

    /**
     * Set person_sync_to_outlook
     *
     * @param boolean $personSyncToOutlook
     * @return Person
     */
    public function setPersonSyncToOutlook($personSyncToOutlook)
    {
        $this->person_sync_to_outlook = $personSyncToOutlook;

        return $this;
    }

    /**
     * Get person_sync_to_outlook
     *
     * @return boolean 
     */
    public function getPersonSyncToOutlook()
    {
        return $this->person_sync_to_outlook;
    }

    /**
     * Set person_is_account
     *
     * @param boolean $personIsAccount
     * @return Person
     */
    public function setPersonIsAccount($personIsAccount)
    {
        $this->person_is_account = $personIsAccount;

        return $this;
    }

    /**
     * Get person_is_account
     *
     * @return boolean 
     */
    public function getPersonIsAccount()
    {
        return $this->person_is_account;
    }

    /**
     * Set person_is_contact
     *
     * @param boolean $personIsContact
     * @return Person
     */
    public function setPersonIsContact($personIsContact)
    {
        $this->person_is_contact = $personIsContact;

        return $this;
    }

    /**
     * Get person_is_contact
     *
     * @return boolean 
     */
    public function getPersonIsContact()
    {
        return $this->person_is_contact;
    }

    /**
     * Set person_is_lead
     *
     * @param boolean $personIsLead
     * @return Person
     */
    public function setPersonIsLead($personIsLead)
    {
        $this->person_is_lead = $personIsLead;

        return $this;
    }

    /**
     * Get person_is_lead
     *
     * @return boolean 
     */
    public function getPersonIsLead()
    {
        return $this->person_is_lead;
    }

    /**
     * Set person_account
     *
     * @param \Account $personAccount
     * @return Person
     */
    public function setPersonAccount(\App\Entities\Account $personAccount = null)
    {
        $this->person_account = $personAccount;

        return $this;
    }

    /**
     * Get person_account
     *
     * @return \Account 
     */
    public function getPersonAccount()
    {
        return $this->person_account;
    }
}
