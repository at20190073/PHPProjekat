<?php

class User{
    public $IdKor;
    public $username;
    public $password;
    public $ime;
    public $prezime;

    public function __construct($IdKor=null, $username=null, $password=null, $ime=null, $prezime=null)
    {
        $this->IdKor = $IdKor;
        $this->username = $username;
        $this->password = $password;
        $this->prezime = $prezime;
        $this->ime = $ime;
    }

    public static function logInUser($usr, mysqli $conn)
    {
        $query = "SELECT * FROM user WHERE username='$usr->username' and password='$usr->password'";
        return $conn->query($query);
    }
}


?>