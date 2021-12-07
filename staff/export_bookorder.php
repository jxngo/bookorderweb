<?php
session_start();

require_once "../utils/db_connect.php";

$semester = $_SESSION['current_semester'];
if($results = $conn->query("SELECT cid, semester, booktitle, authornames, edition, publisher, isbn FROM bookrequests WHERE semester='$semester'")) {
    if($results->num_rows > 0) {
        $delimiter = ",";
        $filename = $semester.".csv";
        $f = fopen('php://memory', 'w');
        $fields = array('cid', 'semester', 'title', 'author', 'edition', 'publisher', 'isbn');
        fputcsv($f, $fields, $delimiter);
    
        while($row = $results->fetch_assoc()) {
            $lineData = array($row['cid'], $row['semester'], $row['booktitle'], $row['authornames'], $row['edition'], $row['publisher'], $row['isbn']);
            fputcsv($f,$lineData,$delimiter);
        }
        fseek($f,0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'. $filename . '";');
    
        fpassthru($f);
    }
}
exit;
?>