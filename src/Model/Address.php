<?php

namespace App\Model;

class Address
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $postnumber;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country;

    /**
     * @var User
     */
    private $user;

    /**
     * @param $id
     * @param int    $user_id
     * @param string $street
     * @param string $postnumber
     * @param string $city
     * @param string $country
     * @param $user
     */
    public function __construct(
        $id,
        int $user_id,
        string $street,
        string $postnumber,
        string $city,
        string $country,
        $user
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->street = $street;
        $this->postnumber = $postnumber;
        $this->city = $city;
        $this->country = $country;
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getPostnumber(): string
    {
        return $this->postnumber;
    }

    /**
     * @param string $postnumber
     */
    public function setPostnumber(string $postnumber)
    {
        $this->postnumber = $postnumber;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}