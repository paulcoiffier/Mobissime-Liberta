<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 16/01/2015
 * Time: 01:19
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
 * @Entity @Table(name="menu_item")
 **/
class MenuItem
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    public $id;

    /** @Column(type="string") * */
    public $menu_item_name;

    /** @Column(type="string") * */
    public $menu_item_position;

    /** @Column(type="string", nullable=true) * */
    public $menu_static_link;

    /** @Column(type="string") * */
    public $menu_descriptiop;

    /** @Column(type="string", nullable=true) * */
    public $menu_font_awesome_icon;

    /**
     * @ManyToOne(targetEntity="Menu", cascade={"persist", "merge"})
     * @JoinColumn(name="menu_id", referencedColumnName="id")
     */
    public $menu;

    /**
     * @ManyToOne(targetEntity="Module", cascade={"persist", "merge"})
     * @JoinColumn(name="module_id", referencedColumnName="id", nullable=true)
     */
    public $module;


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
     * Set menu_item_name
     *
     * @param string $menuItemName
     * @return MenuItem
     */
    public function setMenuItemName($menuItemName)
    {
        $this->menu_item_name = $menuItemName;

        return $this;
    }

    /**
     * Get menu_item_name
     *
     * @return string 
     */
    public function getMenuItemName()
    {
        return $this->menu_item_name;
    }

    /**
     * Set menu_item_position
     *
     * @param string $menuItemPosition
     * @return MenuItem
     */
    public function setMenuItemPosition($menuItemPosition)
    {
        $this->menu_item_position = $menuItemPosition;

        return $this;
    }

    /**
     * Get menu_item_position
     *
     * @return string 
     */
    public function getMenuItemPosition()
    {
        return $this->menu_item_position;
    }

    /**
     * Set menu
     *
     * @param \Menu $menu
     * @return MenuItem
     */
    public function setMenu(\App\Entities\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set menu_static_link
     *
     * @param string $menuStaticLink
     * @return MenuItem
     */
    public function setMenuStaticLink($menuStaticLink)
    {
        $this->menu_static_link = $menuStaticLink;

        return $this;
    }

    /**
     * Get menu_static_link
     *
     * @return string 
     */
    public function getMenuStaticLink()
    {
        return $this->menu_static_link;
    }

    /**
     * Set menu_descriptiop
     *
     * @param string $menuDescriptiop
     * @return MenuItem
     */
    public function setMenuDescriptiop($menuDescriptiop)
    {
        $this->menu_descriptiop = $menuDescriptiop;

        return $this;
    }

    /**
     * Get menu_descriptiop
     *
     * @return string 
     */
    public function getMenuDescriptiop()
    {
        return $this->menu_descriptiop;
    }

    /**
     * Set menu_font_awesome_icon
     *
     * @param string $menuFontAwesomeIcon
     * @return MenuItem
     */
    public function setMenuFontAwesomeIcon($menuFontAwesomeIcon)
    {
        $this->menu_font_awesome_icon = $menuFontAwesomeIcon;

        return $this;
    }

    /**
     * Get menu_font_awesome_icon
     *
     * @return string 
     */
    public function getMenuFontAwesomeIcon()
    {
        return $this->menu_font_awesome_icon;
    }

    /**
     * Set module
     *
     * @param \Module $module
     * @return MenuItem
     */
    public function setModule(\App\Entities\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \Module 
     */
    public function getModule()
    {
        return $this->module;
    }
}
