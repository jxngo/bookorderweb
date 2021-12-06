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
$email_err = $password_err = $login_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    # check for empty email field
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    # check for empty password field
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if(empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, type, firstname, lastname FROM `users` WHERE email=? AND password=?";
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
                } else {
                    $login_err = "Invalid login or password.";
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
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<title>Login</title>
</head>
<body>
	<div class="container">
        <h2>Login | Bookorder</h2>
		<form action="index.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="jane@doe.com">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="">
            </div>
                <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
        </form>
        No Account? <a class="register" href="register.php">Register Instead</a>
	</div>
</body>
</html>