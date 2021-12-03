<?php

$DB_SERVERNAME = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "password";
$DB_NAME = "group4710";

$conn = new mysqli($DB_SERVERNAME, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
if($conn->connect_error) {
    die("Connection Failed: ". $conn->connect_error);
}
echo "Connected Successfully!";
?>