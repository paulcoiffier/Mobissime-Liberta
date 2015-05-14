<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 21/01/2015
 * Time: 22:31
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
 * @Entity(repositoryClass="App\Repositories\CasesRepository") @Table(name="cases")
 **/
class Cases
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="integer", nullable=true) * */
    public $case_priority;

    /** @Column(type="string", length=50, nullable=true) * */
    public $case_status;

    /** @Column(type="string", length=50, nullable=true) * */
    public $case_type;

    /** @Column(type="string", length=500) * */
    public $case_subject;

    /** @Column(type="string", length=500, nullable=true) * */
    public $case_description;

    /** @Column(type="string", length=50, nullable=true) * */
    public $case_resolution;

    /** @Column(type="datetime", nullable=true) * */
    public $case_date_open;

    /** @Column(type="datetime", nullable=true) * */
    public $case_date_solve;

    /**
     * @ManyToOne(targetEntity="User", cascade={"persist", "merge"})
     * @JoinColumn(name="assigned_user_id", referencedColumnName="id", nullable=true)
     */
    public $assignedTo;

    /**
     * @ManyToOne(targetEntity="User", cascade={"persist", "merge"})
     * @JoinColumn(name="resolved_user_id", referencedColumnName="id", nullable=true)
     */
    public $resolvedBy;

    /**
     * @ManyToOne(targetEntity="Account", cascade={"persist", "merge"})
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    public $case_account;

    /**
     * @ManyToOne(targetEntity="Contact", cascade={"persist", "merge"})
     * @JoinColumn(name="contact_id", referencedColumnName="id")
     */
    public $case_contact;

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
     * Set case_status
     *
     * @param string $caseStatus
     * @return Cases
     */
    public function setCaseStatus($caseStatus)
    {
        $this->case_status = $caseStatus;

        return $this;
    }

    /**
     * Get case_status
     *
     * @return string
     */
    public function getCaseStatus()
    {
        return $this->case_status;
    }

    /**
     * Set case_type
     *
     * @param string $caseType
     * @return Cases
     */
    public function setCaseType($caseType)
    {
        $this->case_type = $caseType;

        return $this;
    }

    /**
     * Get case_type
     *
     * @return string
     */
    public function getCaseType()
    {
        return $this->case_type;
    }

    /**
     * Set case_subject
     *
     * @param string $caseSubject
     * @return Cases
     */
    public function setCaseSubject($caseSubject)
    {
        $this->case_subject = $caseSubject;

        return $this;
    }

    /**
     * Get case_subject
     *
     * @return string
     */
    public function getCaseSubject()
    {
        return $this->case_subject;
    }

    /**
     * Set case_description
     *
     * @param string $caseDescription
     * @return Cases
     */
    public function setCaseDescription($caseDescription)
    {
        $this->case_description = $caseDescription;

        return $this;
    }

    /**
     * Get case_description
     *
     * @return string
     */
    public function getCaseDescription()
    {
        return $this->case_description;
    }

    /**
     * Set case_resolution
     *
     * @param string $caseResolution
     * @return Cases
     */
    public function setCaseResolution($caseResolution)
    {
        $this->case_resolution = $caseResolution;

        return $this;
    }

    /**
     * Get case_resolution
     *
     * @return string
     */
    public function getCaseResolution()
    {
        return $this->case_resolution;
    }

    /**
     * Set case_date_open
     *
     * @param \DateTime $caseDateOpen
     * @return Cases
     */
    public function setCaseDateOpen($caseDateOpen)
    {
        $this->case_date_open = $caseDateOpen;

        return $this;
    }

    /**
     * Get case_date_open
     *
     * @return \DateTime
     */
    public function getCaseDateOpen()
    {
        return $this->case_date_open;
    }

    /**
     * Set case_date_solve
     *
     * @param \DateTime $caseDateSolve
     * @return Cases
     */
    public function setCaseDateSolve($caseDateSolve)
    {
        $this->case_date_solve = $caseDateSolve;

        return $this;
    }

    /**
     * Get case_date_solve
     *
     * @return \DateTime
     */
    public function getCaseDateSolve()
    {
        return $this->case_date_solve;
    }

    /**
     * Set case_person
     *
     * @param \Person $casePerson
     * @return Cases
     */
    public function setCasePerson(\App\Entities\Person $casePerson = null)
    {
        $this->case_person = $casePerson;

        return $this;
    }

    /**
     * Get case_person
     *
     * @return \Person
     */
    public function getCasePerson()
    {
        return $this->case_person;
    }

    /**
     * Set assignedTo
     *
     * @param \User $assignedTo
     * @return Cases
     */
    public function setAssignedTo(\App\Entities\User $assignedTo = null)
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    /**
     * Get assignedTo
     *
     * @return \User
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }

    /**
     * Set resolvedBy
     *
     * @param \User $resolvedBy
     * @return Cases
     */
    public function setResolvedBy(\App\Entities\User $resolvedBy = null)
    {
        $this->resolvedBy = $resolvedBy;

        return $this;
    }

    /**
     * Get resolvedBy
     *
     * @return \User
     */
    public function getResolvedBy()
    {
        return $this->resolvedBy;
    }

    /**
     * Set case_account
     *
     * @param \Account $caseAccount
     * @return Cases
     */
    public function setCaseAccount(\App\Entities\Account $caseAccount = null)
    {
        $this->case_account = $caseAccount;

        return $this;
    }

    /**
     * Get case_account
     *
     * @return \Account
     */
    public function getCaseAccount()
    {
        return $this->case_account;
    }


    /**
     * Set case_contact
     *
     * @param \Contact $caseContact
     * @return Cases
     */
    public function setCaseContact(\App\Entities\Contact $caseContact = null)
    {
        $this->case_contact = $caseContact;

        return $this;
    }

    /**
     * Get case_contact
     *
     * @return \Contact 
     */
    public function getCaseContact()
    {
        return $this->case_contact;
    }

    /**
     * Set case_priority
     *
     * @param \int $casePriority
     * @return Cases
     */
    public function setCasePriority($casePriority)
    {
        $this->case_priority = $casePriority;

        return $this;
    }

    /**
     * Get case_priority
     *
     * @return \int 
     */
    public function getCasePriority()
    {
        return $this->case_priority;
    }
}
