<?php
    session_start();
    require_once "../utils/db_connect.php";
    require_once "../utils/utils.php";

    $email = $_POST['clear_form'];
    if($conn->query("DELETE FROM bookrequests WHERE email = '$email'")) {
        header("location: /professor/edit_form.php");
    }

    $stmt->close();
    $conn->close();
?>