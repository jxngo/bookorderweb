<?php
// Initialize the session
session_start();
 
// Include config file
require_once "db_connect.php";
require_once "utils.php";
 

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
            $_SESSION['email'] = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1) {
                    $new_password = generateRandomString(7);
                    $message = "Your new password is: " . $new_password . "\r\n Login at: http://localhost/";

                    if($stmt2 = $conn->prepare("UPDATE users SET password = ? WHERE email = ?")){
                        // Bind variables to the prepared statement as parameters
                        $stmt2->bind_param("ss", $param_password, $param_email);
                        
                        // Set parameters
                        $param_password = $new_password;
                        $param_email = $email;
                        
                        // Attempt to execute the prepared statement
                        if($stmt2->execute()){
                            # password update successful
                            mail($email, "Password Reset", $message);
                            $_SESSION['resetpass'] = true;
                            header("location: index.php");
                        }
            
                        // Close statement
                        $stmt2->close();
                    }
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
<div class="login-form">
    <form action="forgot_password.php" method="post">
        <h2 class="text-center">Forgot Password</h2>        
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Request Temporary Password</button>
        </div>  
    </form>
    <p class="text-center">Remember? <a href="index.php"> Return back to login</a></p>
</div>
</body>
</html>