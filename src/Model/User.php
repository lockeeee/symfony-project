<?php

namespace App\Model;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var int
     */
    private $pnumber;

    /**
     * @param $id
     * @param string $name
     * @param string $surname
     * @param string $mail
     * @param int    $pnumber
     */
    public function __construct($id, string $name, string $surname, string $mail, int $pnumber)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
        $this->pnumber = $pnumber;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return int
     */
    public function getPnumber(): int
    {
        return $this->pnumber;
    }

    /**
     * @param int $pnumber
     */
    public function setPnumber(int $pnumber)
    {
        $this->pnumber = $pnumber;
    }
}

