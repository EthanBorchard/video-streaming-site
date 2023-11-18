<?php
session_start();
include '../db.php';

if (!isset($_SESSION['userid'])) {
    echo "User not logged in";
    exit;
}

$userId = $_SESSION['userid'];
$unique = false;

while (!$unique) {
    $sqlRandomMovie = "SELECT MovieID FROM Movie ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sqlRandomMovie);
    $row = $result->fetch_assoc();
    $randomMovieId = $row['MovieID'];

    $checkQuery = "SELECT * FROM WatchedMovie WHERE UserID = '$userId' AND MovieID = '$randomMovieId'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        $unique = true;
    }
}

$randomWatchCount = rand(1, 10);

$insertQuery = "INSERT INTO WatchedMovie (UserID, MovieID, WatchCount) VALUES ('$userId', '$randomMovieId', '$randomWatchCount')";
if ($conn->query($insertQuery) === TRUE) {
    echo "Random movie added successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
