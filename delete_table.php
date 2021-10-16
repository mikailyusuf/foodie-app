<?php
require_once('Connection.php');
$connection = new Connection();

// Create connection
$conn = new mysqli($connection->servername, $connection->username, $connection->password, $connection->dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "DELETE FROM restaurants";

if ($conn->query($sql) === TRUE) {
    echo "Table Deleted successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>