<?php

class Connection
{

    public $devServername = "localhost";
    public $devUsername = "root";
    public $devPassword = "password";
    public $devDbname = "foodie";

     public $servername = "us-cdbr-east-04.cleardb.com";
    public $username = "b3b7a278827dcb";
    public $password = "bd4020e6";
    public $dbname = "heroku_556bf5eabda18a8";

    function connectToLocalDb(){
        $conn = mysqli_connect($this->devServername, $this->devUsername, $this->devPassword, $this->devDbname);
        if (!$conn) {
            die("Connection failed:" . mysqli_connect_error());
        }
        return $conn;
    }

    function connectToliveDb(){
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        if (!$conn) {
            die("Connection failed:" . mysqli_connect_error());
        }
       return $conn;
    }

}

?>