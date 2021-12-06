<?php
// Include config file
require_once "db_connect.php";
 
// Define variables and initialize with empty values
$email = $password = $firstname = $lastname = $confirm_password = "";
$email_err = $password_err = $firstname_err = $lastname_err = $confirm_password_err = "";
 
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
	if(empty(trim($_POST["firstname"]))) {
		$firstname_err = "Please enter a first name";
	} else {
		$firstname = trim($_POST["firstname"]);
	}
	
	// Validate lastname
	if(empty(trim($_POST["lastname"]))) {
		$lastname_err = "Please enter a last name";
	} else {
		$lastname = trim($_POST["lastname"]);
	}

    // Validate email
    if(empty(trim($_POST["email"]))) {
		$email_err = "Please enter an email.";
	} else {
		$email = trim($_POST["email"]);
	}
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users(type, email, password, firstname, lastname) VALUES ('professor', ?, ?, ?, ?)";
         
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
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<title>Register</title>
</head>
<body>
    <div class="container">
        <h2>Login | Bookorder</h2>
		<form action="register.php" method="post">
			<div class="mb-3">
				<label for="firstname" class="form-label">First Name</label>
				<input type="text" name="firstname" class="form-control" placeholder="Jane">
			</div>
            <div class="mb-3">
				<label for="lastname" class="form-label">Last Name</label>
				<input type="text" name="lastname" class="form-control" placeholder="Joe">
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email address</label>
				<input type="email" name="email" class="form-control" placeholder="jane@doe.com">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Password</label>
				<input type="password" name="password" class="form-control" placeholder="">
			</div>
			<div class="mb-3">
				<label for="confirm_password" class="form-label">Confirm Password</label>
				<input type="password" name="confirm_password" class="form-control" placeholder="">
			</div>
			<button type="submit" name="register_btn" class="btn btn-primary">Register Account</button>
		</form>
		Already Have an Account? <a class="register" href="index.php">Login Instead</a>
	</div>
</body>
</html>