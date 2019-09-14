<?php


namespace App\Model;


class Address
{
    private $id;
    private $user_id;
    private $street;
    private $postnumber;
    private $city;
    private $country;
    private $user;

    /**
     * Address constructor.
     * @param $id
     * @param $user_id
     * @param $street
     * @param $postnumber
     * @param $city
     * @param $country
     */
    public function __construct($id, $user_id, $street, $postnumber, $city, $country, $user)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->street = $street;
        $this->postnumber = $postnumber;
        $this->city = $city;
        $this->country = $country;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getPostnumber()
    {
        return $this->postnumber;
    }

    /**
     * @param mixed $postnumber
     */
    public function setPostnumber($postnumber)
    {
        $this->postnumber = $postnumber;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}