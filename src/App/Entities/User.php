<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 15/01/2015
 * Time: 19:29
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
 * @Entity @Table(name="users")
 **/

class User
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") * */
    public $usr_first_name;

    /** @Column(type="string") * */
    public $usr_last_name;

    /** @Column(type="string") * */
    public $usr_email;

    /** @Column(type="string") * */
    public $usr_password;

    /** @Column(type="date", nullable=true) * */
    public $usr_date_naissance;

    /** @Column(type="string", nullable=true) * */
    public $usr_phone;

    /** @Column(type="string", nullable=true) * */
    public $usr_mobile_phone;

    /** @Column(type="date", nullable=true) * */
    public $usr_last_login;

    /** @Column(type="string", nullable=true) * */
    public $usr_language;

    /** @Column(type="string", nullable=true) * */
    public $usr_function;


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
     * Set usr_first_name
     *
     * @param string $usrFirstName
     * @return User
     */
    public function setUsrFirstName($usrFirstName)
    {
        $this->usr_first_name = $usrFirstName;

        return $this;
    }

    /**
     * Get usr_first_name
     *
     * @return string 
     */
    public function getUsrFirstName()
    {
        return $this->usr_first_name;
    }

    /**
     * Set usr_last_name
     *
     * @param string $usrLastName
     * @return User
     */
    public function setUsrLastName($usrLastName)
    {
        $this->usr_last_name = $usrLastName;

        return $this;
    }

    /**
     * Get usr_last_name
     *
     * @return string 
     */
    public function getUsrLastName()
    {
        return $this->usr_last_name;
    }

    /**
     * Set usr_password
     *
     * @param string $usrPassword
     * @return User
     */
    public function setUsrPassword($usrPassword)
    {
        $this->usr_password = $usrPassword;

        return $this;
    }

    /**
     * Get usr_password
     *
     * @return string 
     */
    public function getUsrPassword()
    {
        return $this->usr_password;
    }

    /**
     * Set usr_date_naissance
     *
     * @param \DateTime $usrDateNaissance
     * @return User
     */
    public function setUsrDateNaissance($usrDateNaissance)
    {
        $this->usr_date_naissance = $usrDateNaissance;

        return $this;
    }

    /**
     * Get usr_date_naissance
     *
     * @return \DateTime 
     */
    public function getUsrDateNaissance()
    {
        return $this->usr_date_naissance;
    }

    /**
     * Set usr_phone
     *
     * @param string $usrPhone
     * @return User
     */
    public function setUsrPhone($usrPhone)
    {
        $this->usr_phone = $usrPhone;

        return $this;
    }

    /**
     * Get usr_phone
     *
     * @return string 
     */
    public function getUsrPhone()
    {
        return $this->usr_phone;
    }

    /**
     * Set usr_mobile_phone
     *
     * @param string $usrMobilePhone
     * @return User
     */
    public function setUsrMobilePhone($usrMobilePhone)
    {
        $this->usr_mobile_phone = $usrMobilePhone;

        return $this;
    }

    /**
     * Get usr_mobile_phone
     *
     * @return string 
     */
    public function getUsrMobilePhone()
    {
        return $this->usr_mobile_phone;
    }

    /**
     * Set usr_last_login
     *
     * @param \DateTime $usrLastLogin
     * @return User
     */
    public function setUsrLastLogin($usrLastLogin)
    {
        $this->usr_last_login = $usrLastLogin;

        return $this;
    }

    /**
     * Get usr_last_login
     *
     * @return \DateTime 
     */
    public function getUsrLastLogin()
    {
        return $this->usr_last_login;
    }

    /**
     * Set usr_email
     *
     * @param string $usrEmail
     * @return User
     */
    public function setUsrEmail($usrEmail)
    {
        $this->usr_email = $usrEmail;

        return $this;
    }

    /**
     * Get usr_email
     *
     * @return string 
     */
    public function getUsrEmail()
    {
        return $this->usr_email;
    }

    /**
     * Set usr_language
     *
     * @param string $usrLanguage
     * @return User
     */
    public function setUsrLanguage($usrLanguage)
    {
        $this->usr_language = $usrLanguage;

        return $this;
    }

    /**
     * Get usr_language
     *
     * @return string 
     */
    public function getUsrLanguage()
    {
        return $this->usr_language;
    }

    /**
     * Set usr_function
     *
     * @param string $usrFunction
     * @return User
     */
    public function setUsrFunction($usrFunction)
    {
        $this->usr_function = $usrFunction;

        return $this;
    }

    /**
     * Get usr_function
     *
     * @return string 
     */
    public function getUsrFunction()
    {
        return $this->usr_function;
    }
}
