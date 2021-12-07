<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hello Professor <b><?php echo htmlspecialchars($_SESSION["lastname"]); ?></b> Welcome to our site.</h1>
    <p>
        <a href="new_form.php" class="btn btn-primary">Submit New Book Request</a>
        <br></br>
        <a href="edit_form.php" class="btn btn-primary">View and Edit Current Book Request</a>
    </p>
    <p>
        <a href="reset_password.php" class="btn btn-danger ml-3">Change Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a> 
    </p>
</body>
</html>