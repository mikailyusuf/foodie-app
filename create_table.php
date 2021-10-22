<?php
require_once('Connection.php');
$connection = new Connection();

// Create connection
$conn = new mysqli($connection->servername, $connection->username, $connection->password, $connection->dbname);
// Check connection

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

//if ($connection->connectToLocalDb()->query($sql) === TRUE) {
//    echo "Table created successfully";
//} else {
//    echo "Error creating table: " . $conn->error;
//}

$createFoodItemSQL = "CREATE TABLE food_items (
id VARCHAR(255) NOT NULL,
name VARCHAR(30) NOT NULL,
description VARCHAR(50),
price VARCHAR(50),
restaurant_token VARCHAR(50),
is_available VARCHAR(5),
image_url VARCHAR(5),
date_uploaded TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($connection->connectToLocalDb()->query($createFoodItemSQL) === TRUE) {
    echo "Food Item created successfully";
} else {
    echo "Error creating food table: " . $conn->error;
}


$connection->connectToLocalDb()->close();
?>