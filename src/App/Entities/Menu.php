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
 * @Entity @Table(name="menu")
 **/
class Menu
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    public $id;

    /** @Column(type="string") * */
    public $menu_name;

    /** @Column(type="string") * */
    public $menu_description;

    /** @Column(type="string", nullable=true) * */
    public $menu_static_link;

    /** @Column(type="string", nullable=true) * */
    public $menu_font_awesome_icon;

    /** @Column(type="integer", nullable=true, options={"unsigned":true, "default":0}) * */
    public $menu_order;

    /**
     * @OneToMany(targetEntity="MenuItem", mappedBy="menu",cascade={"persist", "merge", "remove"})
     **/
    private $menuItems;

    /**
     * @ManyToOne(targetEntity="Module", cascade={"persist", "merge"})
     * @JoinColumn(name="module_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $module;

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
     * Set menu_name
     *
     * @param string $menuName
     * @return Menu
     */
    public function setMenuName($menuName)
    {
        $this->menu_name = $menuName;

        return $this;
    }

    /**
     * Get menu_name
     *
     * @return string
     */
    public function getMenuName()
    {
        return $this->menu_name;
    }

    /**
     * Set menu_description
     *
     * @param string $menuDescription
     * @return Menu
     */
    public function setMenuDescription($menuDescription)
    {
        $this->menu_description = $menuDescription;

        return $this;
    }

    /**
     * Get menu_description
     *
     * @return string
     */
    public function getMenuDescription()
    {
        return $this->menu_description;
    }

    /**
     * Set menu_static_link
     *
     * @param string $menuStaticLink
     * @return Menu
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
     * Constructor
     */
    public function __construct()
    {
        $this->menuItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add menuItems
     *
     * @param \MenuItem $menuItems
     * @return Menu
     */
    public function addMenuItem(\App\Entities\MenuItem $menuItems)
    {
        $this->menuItems[] = $menuItems;

        return $this;
    }

    /**
     * Remove menuItems
     *
     * @param \MenuItem $menuItems
     */
    public function removeMenuItem(\App\Entities\MenuItem $menuItems)
    {
        $this->menuItems->removeElement($menuItems);
    }

    /**
     * Get menuItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuItems()
    {
        return $this->menuItems;
    }

    /**
     * Set module
     *
     * @param \Module $module
     * @return Menu
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

    /**
     * Set menu_order
     *
     * @param \int $menuOrder
     * @return Menu
     */
    public function setMenuOrder($menuOrder)
    {
        $this->menu_order = $menuOrder;

        return $this;
    }

    /**
     * Get menu_order
     *
     * @return \int
     */
    public function getMenuOrder()
    {
        return $this->menu_order;
    }

    /**
     * Set menu_font_awesome_icon
     *
     * @param string $menuFontAwesomeIcon
     * @return Menu
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
}
