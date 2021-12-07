<?php
session_start();

require_once "../utils/db_connect.php";
require_once "../utils/utils.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['account_email'];
    $sql = "DELETE FROM users WHERE email='$email'";
    if($conn->query($sql)) {
        $conn->close();
        header("location: /staff/manage_faculty.php");
    }
}

?>