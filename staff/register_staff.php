<?php
// Include config file
session_start();
require_once "../utils/db_connect.php";
require_once "../utils/utils.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["acctype"] != "staff"){
    header("location: ../");
    exit;
} 
 
// Define variables and initialize with empty values
$email = $password = $firstname = $lastname = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } 
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    // Validate firstname
	if(isset($_POST["firstname"]) && !empty(trim($_POST["firstname"]))) {
		$firstname = trim($_POST["firstname"]);
	}
	
	// Validate lastname
	if(isset($_POST["lastname"]) && !empty(trim($_POST["lastname"]))) {
		$lastname = trim($_POST["lastname"]);
	}

    // Validate email
    if(isset($_POST["email"]) && !empty(trim($_POST["email"]))) {
		$email = trim($_POST["email"]);
	}

    $password = generateRandomString(7);

    // Check input errors before inserting in database
    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users(acctype, email, password, firstname, lastname) VALUES ('staff', ?, ?, ?, ?)";
         
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_email, $param_password, $param_firstname, $param_lastname);
            
            // Set parameters
            $param_email = $email;
            #$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_password = $password;
			$param_firstname = $firstname;
			$param_lastname = $lastname;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // send email to new account holder 

                mail($email, "Staff Login", $_SESSION['email'] . " has created you a staff account!\nYou can login at http://localhost/ with the temporary password: " . $password);
                header("location: ../");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
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
                <a class="nav-link" href="/staff/manage_faculty.php">Manage Faculty</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/staff/manage_reminders.php">Manage Reminders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/staff/manage_bookrequests.php">Manage Book Requests</a>
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
              <a class="dropdown-item" href="/staff/register_staff.php">Create Staff Account</a>
              <a class="dropdown-item" href="/staff/invite_professor.php">Invite Professor</a>
              <a class="dropdown-item" href="../logout.php">Logout</a>
            </div>
          </div>
        </ul>
    </div>
</nav>

<div class="login-form">
    <form action="/staff/register_staff.php" method="post">
        <h2 class="text-center">Staff Registration</h2>
        <div class="form-group">
            <input type="text" name="firstname" class="form-control" placeholder="First name" required="required">
        </div>
        <div class="form-group">
            <input type="text" name="lastname" class="form-control" placeholder="Last name" required="required">
        </div>    
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>      
    </form>
    <p class="text-center">Temporary Password will be sent to the email provided.</p>
</div>
</body>
</html>