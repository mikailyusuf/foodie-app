<?php
require_once('Connection.php');
$connection = new Connection();

// Check connection
if ($connection->connectToDb()->connect_error) {
    die("Connection failed: " . $connection->connectToDb()->connect_error);
}

// sql to create table
//$sql = "DELETE FROM restaurants";
//
//if ($connection->connectToDb()->query($sql) === TRUE) {
//    echo "Table Deleted successfully";
//} else {
//    echo "Error creating table: " . $connection->connectToDb()->error;
//}

$sql = "DELETE FROM food_items";


if ($connection->connectToDb()->query($sql) === TRUE) {
    echo "Table Deleted successfully";
} else {
    echo "Error creating table: " . $connection->connectToDb()->error;
}

$connection->connectToDb()->close();
?>