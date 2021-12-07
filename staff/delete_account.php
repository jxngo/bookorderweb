<?php
session_start();

require_once "../utils/db_connect.php";

$sql = "DELETE FROM users WHERE email='". $_SESSION['account_email'] . "'";
if($conn->query($sql)) {
    header("location: manage_faculty.php");
}
$conn->close();
?>