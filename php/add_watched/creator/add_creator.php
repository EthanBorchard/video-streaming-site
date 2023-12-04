<?php
session_start();
include '../../db.php';

if (!isset($_SESSION['userid'])) {
    echo "User not logged in";
    exit;
}

$userId = $_SESSION['userid'];
$CreatorId = $conn->real_escape_string($_POST['CreatorId']);
$hoursWatched = $conn->real_escape_string($_POST['HoursWatched']);

$checkQuery = "SELECT * 
               FROM WatchedCreator 
               WHERE UserID = '$userId' 
               AND CreatorID = '$CreatorId'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
    $updateQuery = "UPDATE WatchedCreator 
                    SET HoursWatched = '$hoursWatched' 
                    WHERE UserID = '$userId' 
                    AND CreatorID = '$CreatorId'";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Hours watched updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $insertQuery = "INSERT INTO WatchedCreator (UserID, CreatorID, HoursWatched) 
                    VALUES ('$userId', '$CreatorId', '$hoursWatched')";
    if ($conn->query($insertQuery) === TRUE) {
        echo "New watched content creator entry added successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>

