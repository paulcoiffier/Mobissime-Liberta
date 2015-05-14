<?php
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
use Doctrine\ORM\Mapping as ORM;


/**
 * @Entity(repositoryClass="App\Repositories\AccountRepository") @Table(name="accounts")
 **/
class Account
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    public $id;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_name;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_phone_office;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_phone_mobile;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_fax;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_street;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_city;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_postal_code;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_country;

    /** @Column(type="string", length=255, nullable=false) * */
    public $account_state;


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
     * Set account_name
     *
     * @param string $accountName
     * @return Account
     */
    public function setAccountName($accountName)
    {
        $this->account_name = $accountName;

        return $this;
    }

    /**
     * Get account_name
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->account_name;
    }

    /**
     * Set account_phone_office
     *
     * @param string $accountPhoneOffice
     * @return Account
     */
    public function setAccountPhoneOffice($accountPhoneOffice)
    {
        $this->account_phone_office = $accountPhoneOffice;

        return $this;
    }

    /**
     * Get account_phone_office
     *
     * @return string
     */
    public function getAccountPhoneOffice()
    {
        return $this->account_phone_office;
    }

    /**
     * Set account_phone_mobile
     *
     * @param string $accountPhoneMobile
     * @return Account
     */
    public function setAccountPhoneMobile($accountPhoneMobile)
    {
        $this->account_phone_mobile = $accountPhoneMobile;

        return $this;
    }

    /**
     * Get account_phone_mobile
     *
     * @return string
     */
    public function getAccountPhoneMobile()
    {
        return $this->account_phone_mobile;
    }

    /**
     * Set account_fax
     *
     * @param string $accountFax
     * @return Account
     */
    public function setAccountFax($accountFax)
    {
        $this->account_fax = $accountFax;

        return $this;
    }

    /**
     * Get account_fax
     *
     * @return string
     */
    public function getAccountFax()
    {
        return $this->account_fax;
    }

    /**
     * Set account_street
     *
     * @param string $accountStreet
     * @return Account
     */
    public function setAccountStreet($accountStreet)
    {
        $this->account_street = $accountStreet;

        return $this;
    }

    /**
     * Get account_street
     *
     * @return string
     */
    public function getAccountStreet()
    {
        return $this->account_street;
    }

    /**
     * Set account_city
     *
     * @param string $accountCity
     * @return Account
     */
    public function setAccountCity($accountCity)
    {
        $this->account_city = $accountCity;

        return $this;
    }

    /**
     * Get account_city
     *
     * @return string
     */
    public function getAccountCity()
    {
        return $this->account_city;
    }

    /**
     * Set account_postal_code
     *
     * @param string $accountPostalCode
     * @return Account
     */
    public function setAccountPostalCode($accountPostalCode)
    {
        $this->account_postal_code = $accountPostalCode;

        return $this;
    }

    /**
     * Get account_postal_code
     *
     * @return string
     */
    public function getAccountPostalCode()
    {
        return $this->account_postal_code;
    }

    /**
     * Set account_country
     *
     * @param string $accountCountry
     * @return Account
     */
    public function setAccountCountry($accountCountry)
    {
        $this->account_country = $accountCountry;

        return $this;
    }

    /**
     * Get account_country
     *
     * @return string
     */
    public function getAccountCountry()
    {
        return $this->account_country;
    }

    /**
     * Set account_state
     *
     * @param string $accountState
     * @return Account
     */
    public function setAccountState($accountState)
    {
        $this->account_state = $accountState;

        return $this;
    }

    /**
     * Get account_state
     *
     * @return string
     */
    public function getAccountState()
    {
        return $this->account_state;
    }
}
