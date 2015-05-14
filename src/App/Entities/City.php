<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 25/01/2015
 * Time: 22:55
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
 * @Entity @Table(name="cities")
 **/
class City
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string", nullable=true) * */
    public $loc_postal_code;

    /** @Column(type="string", nullable=true) * */
    public $loc_insee;

    /** @Column(type="string", nullable=true) * */
    public $loc_city;

    /** @Column(type="string", nullable=true) * */
    public $loc_city_bis;

    /** @Column(type="string", nullable=true) * */
    public $loc_name;

    /** @Column(type="string", nullable=true) * */
    public $loc_region;

    /** @Column(type="string", nullable=true) * */
    public $loc_region_name;

    /** @Column(type="string", nullable=true) * */
    public $loc_dep;

    /** @Column(type="string", nullable=true) * */
    public $loc_dep_name;

    /** @Column(type="string", nullable=true) * */
    public $loc_longitude;

    /** @Column(type="string", nullable=true) * */
    public $loc_latitude;





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
     * Set loc_postal_code
     *
     * @param string $locPostalCode
     * @return City
     */
    public function setLocPostalCode($locPostalCode)
    {
        $this->loc_postal_code = $locPostalCode;

        return $this;
    }

    /**
     * Get loc_postal_code
     *
     * @return string 
     */
    public function getLocPostalCode()
    {
        return $this->loc_postal_code;
    }

    /**
     * Set loc_insee
     *
     * @param string $locInsee
     * @return City
     */
    public function setLocInsee($locInsee)
    {
        $this->loc_insee = $locInsee;

        return $this;
    }

    /**
     * Get loc_insee
     *
     * @return string 
     */
    public function getLocInsee()
    {
        return $this->loc_insee;
    }

    /**
     * Set loc_city
     *
     * @param string $locCity
     * @return City
     */
    public function setLocCity($locCity)
    {
        $this->loc_city = $locCity;

        return $this;
    }

    /**
     * Get loc_city
     *
     * @return string 
     */
    public function getLocCity()
    {
        return $this->loc_city;
    }

    /**
     * Set loc_city_bis
     *
     * @param string $locCityBis
     * @return City
     */
    public function setLocCityBis($locCityBis)
    {
        $this->loc_city_bis = $locCityBis;

        return $this;
    }

    /**
     * Get loc_city_bis
     *
     * @return string 
     */
    public function getLocCityBis()
    {
        return $this->loc_city_bis;
    }

    /**
     * Set loc_name
     *
     * @param string $locName
     * @return City
     */
    public function setLocName($locName)
    {
        $this->loc_name = $locName;

        return $this;
    }

    /**
     * Get loc_name
     *
     * @return string 
     */
    public function getLocName()
    {
        return $this->loc_name;
    }

    /**
     * Set loc_region
     *
     * @param string $locRegion
     * @return City
     */
    public function setLocRegion($locRegion)
    {
        $this->loc_region = $locRegion;

        return $this;
    }

    /**
     * Get loc_region
     *
     * @return string 
     */
    public function getLocRegion()
    {
        return $this->loc_region;
    }

    /**
     * Set loc_region_name
     *
     * @param string $locRegionName
     * @return City
     */
    public function setLocRegionName($locRegionName)
    {
        $this->loc_region_name = $locRegionName;

        return $this;
    }

    /**
     * Get loc_region_name
     *
     * @return string 
     */
    public function getLocRegionName()
    {
        return $this->loc_region_name;
    }

    /**
     * Set loc_dep
     *
     * @param string $locDep
     * @return City
     */
    public function setLocDep($locDep)
    {
        $this->loc_dep = $locDep;

        return $this;
    }

    /**
     * Get loc_dep
     *
     * @return string 
     */
    public function getLocDep()
    {
        return $this->loc_dep;
    }

    /**
     * Set loc_dep_name
     *
     * @param string $locDepName
     * @return City
     */
    public function setLocDepName($locDepName)
    {
        $this->loc_dep_name = $locDepName;

        return $this;
    }

    /**
     * Get loc_dep_name
     *
     * @return string 
     */
    public function getLocDepName()
    {
        return $this->loc_dep_name;
    }

    /**
     * Set loc_longitude
     *
     * @param string $locLongitude
     * @return City
     */
    public function setLocLongitude($locLongitude)
    {
        $this->loc_longitude = $locLongitude;

        return $this;
    }

    /**
     * Get loc_longitude
     *
     * @return string 
     */
    public function getLocLongitude()
    {
        return $this->loc_longitude;
    }

    /**
     * Set loc_latitude
     *
     * @param string $locLatitude
     * @return City
     */
    public function setLocLatitude($locLatitude)
    {
        $this->loc_latitude = $locLatitude;

        return $this;
    }

    /**
     * Get loc_latitude
     *
     * @return string 
     */
    public function getLocLatitude()
    {
        return $this->loc_latitude;
    }
}
