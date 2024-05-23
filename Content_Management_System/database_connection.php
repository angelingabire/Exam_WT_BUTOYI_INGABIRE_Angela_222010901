<?php
// Connection details
$host = "localhost";
$user = "Angela";
$pass = "222010901";
$database = "content_management_system";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
