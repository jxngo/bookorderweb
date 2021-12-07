<?php
// Initialize the session
session_start();

 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["acctype"] != "staff"){
    header("location: /");
    exit;
}
 
// Include config file
require_once "../utils/db_connect.php";
 
$new_email = $new_firstname = $new_lastname = $new_acctype = "";

$email = $_SESSION['account_email'];
$firstname = $_SESSION['account_firstname'];
$lastname = $_SESSION['account_lastname'];
$acctype = $_SESSION['account_acctype'];
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    # get new email
    if(isset($_POST['new_email']) && !empty($_POST['new_email'])) {
        $new_email = trim($_POST['new_email']);
    } else {
        $new_email = $email;
    }

    # get new firstname
    if(isset($_POST['new_firstname']) && !empty($_POST['new_firstname'])) {
        $new_firstname = trim($_POST['new_firstname']);
    } else {
        $new_firstname = $firstname;
    }
    
    # get new lastname
    if(isset($_POST['new_lastname']) && !empty($_POST['new_lastname'])) {
        $new_lastname = trim($_POST['new_lastname']);
    } else {
        $new_lastname = $lastname;
    }

    # get new acctype
    if(isset($_POST['new_acctype']) && !empty($_POST['new_acctype'])) {
        $new_acctype = trim($_POST['new_acctype']);
    } else {
        $new_acctype = $acctype;
    }


    $sql = "UPDATE users SET email='" . $new_email . "', firstname='" . $new_firstname . "', lastname='" . $new_lastname . "', acctype='" . $new_acctype . "' WHERE email='" . $email . "'";
    if($conn->query($sql)) {
        header("location: manage_faculty.php");
    }
    $conn->close();
}
?>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Reset Password</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
    .login-form {
        width: 340px;
        margin: 50px auto;
        font-size: 15px;
    }
    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link active" href="manage_faculty.php">Manage Faculty</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_reminders.php">Manage Reminders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_bookrequests.php">Manage Book Requests</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="/staff">Book Order</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION["email"]; ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="../reset_password.php">Reset Password</a>
              <a class="dropdown-item" href="register_staff.php">Create Staff Account</a>
              <a class="dropdown-item" href="../logout.php">Logout</a>
            </div>
          </div>
        </ul>
    </div>
</nav>

<form id="delete" action="delete_account.php" method="post"></form>

<div class="login-form">
    <form action="account.php" method="post">
        <h2 class="text-center">Manage User</h2>        
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="text" name="new_email" class="form-control" value=<?php echo $email;?>  placeholder=<?php echo $email;?>>
        </div>
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="new_firstname" class="form-control" value=<?php echo $firstname;?>  placeholder=<?php echo $firstname;?>>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="new_lastname" class="form-control" value=<?php echo $lastname;?> placeholder=<?php echo $lastname;?>>
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="new_acctype" id="staff" value="staff" <?php echo $acctype == "staff" ? "checked" : ""; ?>>
                <label class="form-check-label" for="staff">Staff</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="new_acctype" id="professor" value="professor" <?php echo $acctype == "professor" ? "checked" : ""; ?>>
                <label class="form-check-label" for="professor">Professor</label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Save</button>
            <button type="submit" form="delete" class="btn btn-danger btn-block" id="delete_acc_email" value=<?php echo $email ?> >Delete</button>
        </div>  
    </form>
</div>
</body>
</html>