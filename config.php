<?php 
$sql = file_get_contents('db.sql');
$servername = "localhost";
$username = "root";
$password = "password";

// Create connection
$mysqli = new mysqli($servername, $username, $password);
// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->multi_query($sql);
?>