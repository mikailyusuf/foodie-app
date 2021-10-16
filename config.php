<?php
// $servername = "us-cdbr-east-04.cleardb.com";
// $username = "b3b7a278827dcb";
// $password = "bd4020e6";
// $dbname = "heroku_556bf5eabda18a8";

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "foodie";

$CONNECTION = mysqli_connect($servername, $username, $password, $dbname);
if (!$CONNECTION) {
    die("Connection failed:" . mysqli_connect_error());
}
else{
    // echo ("SUCCESS");
}
