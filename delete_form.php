<?php
    session_start();
    require_once "db_connect.php";
    $isbn = $_POST['del_isbn'];
    $stmt = $conn->prepare("DELETE FROM bookrequests WHERE isbn = $isbn");
    $stmt->execute();
    header("location: edit_form.php");
    $stmt->close();
    $conn->close();
?>