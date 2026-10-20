<?php
$host = "sql308.infinityfree.com";
$user = "if0_43212052";
$password = "YOUR_INFINITYFREE_PASSWORD"; // Your account/panel password
$dbname = "if0_43212052_restaurant_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>