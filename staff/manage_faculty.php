<?php
session_start();

require_once "../utils/db_connect.php";
require_once "../utils/utils.php";

$sql = "SELECT acctype, email, firstname, lastname FROM users WHERE NOT email='group4710@gmail.com' AND NOT email='" . $_SESSION['email'] . "'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Group4710 Book Order</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

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
              <a class="dropdown-item" href="../logout.php">Logout</a>
            </div>
          </div>
        </ul>
    </div>
</nav>

<div class="jumbotron text-center">
<h1 class="display-4">Manage Faculty Page</h1>
</div>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Email</th>
            <th>Account Type</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Account Operations</th>
            
        </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['acctype']; ?></td>
            <td><?php echo $row['firstname']; ?></td>
            <td><?php echo $row['lastname']; ?></td>
            <form action="account.php" method="post"><td><button type="submit" class="btn btn-primary" name="account_email" value=<?php echo $row['email'] ?>><i class="fa fa-eye"></i>View</button></td></form>
          </tr>
      <?php } ?>
    </tbody>
</table>

</body>
</html>