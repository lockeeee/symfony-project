<?php


namespace App\Model;


class User
{
    private $id;
    private $name;
    private $surname;
    private $mail;
    private $pnumber;

    /**
     * User constructor.
     * @param $id
     * @param $name
     * @param $surname
     * @param $mail
     * @param $pnumber
     */
    public function __construct($id, $name, $surname, $mail, $pnumber)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
        $this->pnumber = $pnumber;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getPnumber()
    {
        return $this->pnumber;
    }

    /**
     * @param mixed $pnumber
     */
    public function setPnumber($pnumber)
    {
        $this->pnumber = $pnumber;
    }

}

