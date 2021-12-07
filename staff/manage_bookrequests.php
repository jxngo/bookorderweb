<?php
session_start();

require_once "../utils/db_connect.php";
require_once "../utils/utils.php";

$semester = "fall2021";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $semester = trim($_POST['semester']);
}
$sql = "SELECT cid, semester, booktitle, authornames, edition, publisher, isbn FROM bookrequests WHERE semester='$semester'";
$result = $conn->query($sql);
$conn->close();
$_SESSION['current_semester'] = $semester;

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
                <a class="nav-link" href="manage_faculty.php">Manage Faculty</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_reminders.php">Manage Reminders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="manage_bookrequests.php">Manage Book Requests</a>
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
<br>
<form id="export" action="export_bookorder.php" method="post"></form>

<form class="form-inline" action="manage_bookrequests.php" method="POST">
    <div class="form-group mb-2">
        <div class="form-group mx-sm-3 mb-2">
            <label for="semester" class="sr-only">Semester</label>
            <input type="text" class="form-control" id="semester" name="semester" placeholder="Semester e.g. 'fall2021'" value=<?php echo $semester ?>>
        </div>
        <div class="form-group mb-2">
            <button type="submit" class="btn btn-primary mb-2">View Semester</button>
            <button type="submit" form="export" class="btn btn-secondary mb-2 float-right">Export</button>
        </div>

    </div>
</form>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>CID</th>
            <th>Semester</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Edition</th>
            <th>Publisher</th>
            <th>ISBN</th>
        </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['cid']; ?></td>
            <td><?php echo $row['semester']; ?></td>
            <td><?php echo $row['booktitle']; ?></td>
            <td><?php echo $row['authornames']; ?></td>
            <td><?php echo $row['edition']; ?></td>
            <td><?php echo $row['publisher']; ?></td>
            <td><?php echo $row['isbn']; ?></td>
          </tr>
      <?php } ?>
    </tbody>
</table>

</body>
</html>