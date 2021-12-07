<?php
// Include config file
session_start();
require_once "db_connect.php";

#define variables and initialize with empty values
$title = $cid = $author = $edition = $publisher = $isbn = "";
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["cid"]) && !empty(trim($_POST["cid"]))) $cid = trim($_POST["cid"]);
    if(isset($_POST["title"]) && !empty(trim($_POST["title"]))) $title = trim($_POST["title"]);
    if(isset($_POST["author"]) && !empty(trim($_POST["author"]))) $author = trim($_POST["author"]);
    if(isset($_POST["edition"]) && !empty(trim($_POST["edition"]))) $edition= trim($_POST["edition"]);
    if(isset($_POST["publisher"]) && !empty(trim($_POST["publisher"]))) $publisher= trim($_POST["publisher"]);
    if(isset($_POST["isbn"]) && !empty(trim($_POST["isbn"]))) $isbn= trim($_POST["isbn"]);
    
    if (!empty($cid) && !empty($title) && !empty($author) && !empty($edition) && !empty($publisher) && !empty($isbn)) {
        $sql = "INSERT INTO bookrequests(cid, email, booktitle, authornames, edition, publisher, isbn) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssss",$param_cid,$param_email,$param_title,$param_author,$param_edition,$param_publisher,$param_isbn);
            $param_cid = $cid;
            $param_email = $email;
            $param_title = $title;
            $param_author = $author;
            $param_edition = $edition;
            $param_publisher = $publisher;
            $param_isbn = $isbn;
            if ($stmt->execute()) {
                header("location: professor.php");
            }
            else { 
                echo "Oops! Something went wrong. Please try again later.";
                echo $stmt->error;
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>New Book Form</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
                width = 50px;
            }
            .form-group {

            }
            .form-row {
                max-width: 50%;
                margin-left: 25%;
                padding-bottom: 20px;
            }
        </style>
    </head>
    <body class="book-form">
        <form action="new_form.php" method="post">
            <h1 class="text-center">New Book Request</h1>
            <div class="form-group">
                <div class="form-row">
                    <text>Class ID:</text>
                    <input type="text" name="cid" class="form-control" placeholder="CID" required="required">
                </div>
                <div class="form-row">
                    <text>Title:</text>
                    <input type="text" name="title" class="form-control" placeholder="Book Title" required="required">
                </div>
                <div class="form-row">
                    <text>Author:</text>
                    <input type="text" name="author" class="form-control" placeholder="Author" required="required">
                </div>
                <div class="form-row">
                    <text>Edition</text>
                    <input type="text" name="edition" class="form-control" placeholder="Edition" required="required">
                </div>
                <div class="form-row">
                    <text>Publisher</text>
                    <input type="text" name="publisher" class="form-control" placeholder="Publisher" required="required">
                </div>
                <div class="form-row">
                    <text>ISBN:</text>
                    <input type="text" name="isbn" class="form-control" placeholder="ISBN" required="required">
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            </div>
        </form>
    </body>
</html>
