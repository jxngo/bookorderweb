<?php
// Include config file
require_once "db_connect.php";
 
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
    
    // Validate password
    if(isset($_POST["password"]) && !empty(trim($_POST["password"]))){
        $password = trim($_POST["password"]);
    }
    
    // Check input errors before inserting in database
    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users(acctype, email, password, firstname, lastname) VALUES ('professor', ?, ?, ?, ?)";
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
                // Redirect to login page
                header("location: index.php");
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
<div class="login-form">
    <form action="register.php" method="post">
        <h2 class="text-center">Professor Registration</h2>
        <div class="form-group">
            <input type="text" name="firstname" class="form-control" placeholder="Firstname" required="required">
        </div>
        <div class="form-group">
            <input type="text" name="lastname" class="form-control" placeholder="Lastname" required="required">
        </div>    
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>      
    </form>
    <p class="text-center">Have an account already? <a href="index.php">Login</a></p>
</div>
</body>
</html>