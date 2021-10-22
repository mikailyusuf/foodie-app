<?php

class ConnectionLocal
{

    public $servername = "localhost";
    public $username = "root";
    public $password = "password";
    public $dbname = "foodie";
    function connectToDb()
    {
        $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        if (!$conn) {
            die("Connection failed:" . mysqli_connect_error());
        }
        return $conn;
    }
}
?>