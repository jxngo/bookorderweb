<?php
    session_start();
    require_once "db_connect.php";
    $email = $_SESSION['email'];
    $sql = "SELECT cid, booktitle, authornames, edition, publisher, isbn FROM bookrequests WHERE email = '$email'";
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
        <h1 class="text-center">Existing Book Request</h1>
        <div class="btn-group">
            <form action ="professor.php"><button type="submit">Home</button></form>
            <form action ="new_form.php"><button type="submit">Add</button></form>
            <form action="clear_form.php" method="post"><td><button type="submit" name="clear_form" value=<? echo $email ?>>Clear All</button></td></form> 
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>CID</th>
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
                    <td><?php echo $row['booktitle']; ?></td>
                    <td><?php echo $row['authornames']; ?></td>
                    <td><?php echo $row['edition']; ?></td>
                    <td><?php echo $row['publisher']; ?></td>
                    <td><?php echo $row['isbn']; ?></td> 
                    <form action="delete_form.php" method="post"><td><button type="submit" class="btn btn-primary" name="del_isbn" value=<? echo $row['isbn'] ?>>Delete</button></td></form> 
                                  
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>
</html>
