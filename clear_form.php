<?php
    session_start();
    require_once "db_connect.php";
    $email = $_POST['clear_form'];
    $stmt = $conn->prepare("DELETE FROM bookrequests WHERE email = $email");
    $stmt->execute();
    header("location: edit_form.php");
    $stmt->close();
    $conn->close();
?>