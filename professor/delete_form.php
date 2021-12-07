<?php
    session_start();
    require_once "../utils/db_connect.php";
    require_once "../utils/utils.php";

    $isbn = $_POST['del_isbn'];
    if($conn->query("DELETE FROM bookrequests WHERE isbn = $isbn")) {
        header("location: /professor/edit_form.php");
    }

    $stmt->close();
    $conn->close();
?>