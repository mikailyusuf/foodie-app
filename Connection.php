<?php

class Connection
{

    public $devServername = "localhost";
    public $devUsername = "root";
    public $devPassword = "password";
    public $devDbname = "foodie";

     public $servername = "us-cdbr-east-04.cleardb.com";
    public $username = "b54f6b3845fedf";
    public $password = "32832b94";
    public $dbname = "heroku_fba6dceb3986572";

    function connectToDb(){
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        if (!$conn) {
            die("Connection failed:" . mysqli_connect_error());
        }
       return $conn;
    }

}

?>