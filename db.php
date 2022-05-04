<?php
$servername = "localhost"; // Change this
$username = "root"; // Change this
$password = ""; // Change this
$dbname = "streem"; // Change this

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Couldn't connect to database");
}

mysqli_set_charset($conn, "utf8");
?>