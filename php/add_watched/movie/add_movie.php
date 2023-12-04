<?php
session_start();
include '../../db.php';

if (!isset($_SESSION['userid'])) {
    echo "User not logged in";
    exit;
}

$userId = $_SESSION['userid'];
$movieId = $conn->real_escape_string($_POST['movieId']);
$watchCount = $conn->real_escape_string($_POST['watchCount']);

$checkQuery = "SELECT * 
               FROM WatchedMovie 
               WHERE UserID = '$userId' 
               AND MovieID = '$movieId'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
    $updateQuery = "UPDATE WatchedMovie 
                    SET WatchCount = '$watchCount' 
                    WHERE UserID = '$userId' 
                    AND MovieID = '$movieId'";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Watch count updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $insertQuery = "INSERT INTO WatchedMovie (UserID, MovieID, WatchCount) 
                    VALUES ('$userId', '$movieId', '$watchCount')";
    if ($conn->query($insertQuery) === TRUE) {
        echo "New watch movie entry added successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>
