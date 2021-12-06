<?php

session_start();

# redirect if already logged in 
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    if($_SESSION['acctype'] == "professor") {
        header("location: professor.php");
    } else if($_SESSION['acctype'] == "staff") {
        header("location: staff.php");
    }
    exit;
}

# otherwise go ahead and connect to database
require_once "db_connect.php";

$email = $password = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    # check for empty email field
    if(isset($_POST["email"]) && !empty(trim($_POST["email"]))) {
        $email = trim($_POST["email"]);
    }

    # check for empty password field
    if(isset($_POST["password"]) && !empty(trim($_POST["password"]))) {
        $password = trim($_POST["password"]);
    }

    if(!empty($email) && !empty($password)) {
        $sql = "SELECT id, acctype, firstname, lastname FROM `users` WHERE email=? AND password=?";
        if($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_email, $param_password);

            # set params
            $param_email = $email;
            $param_password = $password;

            if($stmt->execute()) {
                $stmt->store_result();
                if($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $acctype, $firstname, $lastname);
                    if($stmt->fetch()) {
                        session_start();

                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $id;
                        $_SESSION['email'] = $email;
                        $_SESSION['acctype'] = $acctype;
                        $_SESSION['firstname'] = $firstname;
                        $_SESSION['lastname'] = $lastname;
                        # if acctype is staff or professor
                        if($acctype == "staff") {
                            header("location: staff.php");
                        } else {
                            header("location: professor.php");
                        }
                    }
                }
                $stmt->close();
            }
        }
    }
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
    <form action="index.php" method="post">
        <h2 class="text-center">Book Order Login</h2>        
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
        <div class="clearfix">
            <a href="forgot_password.php" class="float-left">Forgot Password?</a> 
        </div>        
    </form>
    <p class="text-center"><a href="register.php">Create an Account</a></p>
</div>
</body>
</html>