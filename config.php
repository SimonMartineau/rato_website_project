<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "association_database_v3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>