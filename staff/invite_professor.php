<?php
// Initialize the session
session_start();
 
// Include config file
require_once "../utils/db_connect.php";
require_once "../utils/utils.php";
 

// Define variables and initialize with empty values
$email = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate email
    if(isset($_POST["email"]) && !empty(trim($_POST["email"]))){
        $email = trim($_POST["email"]);
    }
    
        
    // Check input errors before updating the database
    if(!empty($email)){
        // Prepare an update statement
        
        if($stmt = $conn->prepare("SELECT * FROM users WHERE email=?")){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1) {
                    // Send an invitation to a particular user
                    mail($email, "Bookorder Invite", $_SESSION['email'] . " has sent you an invitation to join the book order website as a professor!\nYou can register for an account at http://localhost/register.php");
                }
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Group4710 Book Order</title>
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
                <a class="nav-link" href="manage_faculty.php">Manage Faculty</a>
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

<div class="login-form">
    <form action="invite_professor.php" method="post">
        <h2 class="text-center">Invite Professor</h2> 
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Send Invite</button>
        </div>      
    </form>
</div>
</body>
</html>