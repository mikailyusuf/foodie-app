<?php
require_once('Connection.php');

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "foodie";

$connection = new Connection();

// Create connection
$conn = new mysqli($connection->servername, $connection->username, $connection->password, $connection->dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE restaurants (
id VARCHAR(255) NOT NULL,
firstname VARCHAR(30) NOT NULL,
email VARCHAR(50),
phone VARCHAR(50),
is_verified VARCHAR(5),
is_active VARCHAR(50),
user_address VARCHAR(250),
token VARCHAR(200),
user_password VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "Table Mcreated successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>