<?php

namespace AppBundle\Util;

class User
{
    private $email, $lastname, $firstname, $age;

    public function __construct($email, $lastname, $firstname, $age) {
        $this->email = $email;
        $this->lastname = $email;
        $this->firstname = $firstname;
        $this->age = $age;
    }

    public function isValid()
    {
        if (!empty($this->email) && !empty($this->age) && filter_var($this->email, FILTER_VALIDATE_EMAIL) &&$this->age > 13) {
            return true;
        } else {
            return false;
        }
    }
}