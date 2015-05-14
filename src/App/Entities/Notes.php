<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 22/01/2015
* Time: 00:03
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
 * @Entity @Table(name="notes")
 **/
class Notes
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", length=50, nullable=false) * */
    public $note_name;

    /** @Column(type="text", nullable=true) * */
    public $note_description;

    /** @Column(type="datetime", nullable=false) * */
    public $note_date_add;

    /** @Column(type="text", nullable=false) * */
    public $note_content;

    /**
     * @ManyToOne(targetEntity="User", cascade={"persist", "merge"})
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    public $user;


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
     * Set note_name
     *
     * @param string $noteName
     * @return Notes
     */
    public function setNoteName($noteName)
    {
        $this->note_name = $noteName;

        return $this;
    }

    /**
     * Get note_name
     *
     * @return string 
     */
    public function getNoteName()
    {
        return $this->note_name;
    }

    /**
     * Set note_description
     *
     * @param string $noteDescription
     * @return Notes
     */
    public function setNoteDescription($noteDescription)
    {
        $this->note_description = $noteDescription;

        return $this;
    }

    /**
     * Get note_description
     *
     * @return string 
     */
    public function getNoteDescription()
    {
        return $this->note_description;
    }

    /**
     * Set note_date_add
     *
     * @param \DateTime $noteDateAdd
     * @return Notes
     */
    public function setNoteDateAdd($noteDateAdd)
    {
        $this->note_date_add = $noteDateAdd;

        return $this;
    }

    /**
     * Get note_date_add
     *
     * @return \DateTime 
     */
    public function getNoteDateAdd()
    {
        return $this->note_date_add;
    }

    /**
     * Set note_content
     *
     * @param string $noteContent
     * @return Notes
     */
    public function setNoteContent($noteContent)
    {
        $this->note_content = $noteContent;

        return $this;
    }

    /**
     * Get note_content
     *
     * @return string 
     */
    public function getNoteContent()
    {
        return $this->note_content;
    }

    /**
     * Set user
     *
     * @param \User $user
     * @return Notes
     */
    public function setUser(\App\Entities\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
