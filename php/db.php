<?php
$servername = "localhost";
$username = "eborchard";
$password = "RP_28176";
$dbname = "videostreamingDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
