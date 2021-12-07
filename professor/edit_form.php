<?php
    session_start();
    require_once "../utils/db_connect.php";
    $email = $_SESSION['email'];
    $sql = "SELECT cid, semester, booktitle, authornames, edition, publisher, isbn FROM bookrequests WHERE email = '$email'";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Book Request</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <style>
            .btn-group {
                margin-left: 40%;
            }
        </style> 
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="new_form.php">Submit New Book Request</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="edit_form.php">Manage Book Requests</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="/">Book Order</a>
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
    <h1 class="text-center">Existing Book Request</h1>
    <div class="btn-group">
        <form action ="/professor/new_form.php"><button class="btn btn-success" type="submit">Add New Book Request</button></form>
        <form action="/professor/clear_form.php" method="post"><td><button class="btn btn-primary" type="submit" name="clear_form" value=<?php echo $email ?>>Clear All</button></td></form> 
    </div>
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
                <form action="/professor/delete_form.php" method="post"><td><button type="submit" class="btn btn-danger" name="del_isbn" value=<?php echo $row['isbn'] ?>>Delete</button></td></form> 
                                
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>