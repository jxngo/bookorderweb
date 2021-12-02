<?php

session_start();

# redirect if already logged in 
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    header("location: welcome.php");
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
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);

            $param_email = $email;
            if($stmt->execute()) {
                $stmt->store_result();
                if($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $email, $hashed_password);
                    if($stmt->fetch()) {
                        if(password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['email'] = $email;

                            header("location: welcome.php");
                        } else {
                            $login_err = "Invalid login or password.";
                        }
                    }
                } else {
                    $login_err = "Invalid login or password.";
                }
            } else {
                echo "Oops! Something went wrong!";
            }
            $stmt->close();
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