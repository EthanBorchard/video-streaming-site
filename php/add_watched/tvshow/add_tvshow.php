<?php
session_start();
include '../../db.php';

if (!isset($_SESSION['userid'])) {
    echo "User not logged in";
    exit;
}

$userId = $_SESSION['userid'];
$TVShowId = $conn->real_escape_string($_POST['TVShowId']);
$episodesWatched = $conn->real_escape_string($_POST['EpisodesWatched']);

$checkQuery = "SELECT * 
               FROM WatchedTVShow 
               WHERE UserID = '$userId' 
               AND TVShowID = '$TVShowId'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
    $updateQuery = "UPDATE WatchedTVShow 
                    SET EpisodesWatched = '$episodesWatched' 
                    WHERE UserID = '$userId' 
                    AND TVShowID = '$TVShowId'";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Episodes watched updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $insertQuery = "INSERT INTO WatchedTVShow (UserID, TVShowID, EpisodesWatched) 
                    VALUES ('$userId', '$TVShowId', '$episodesWatched')";
    if ($conn->query($insertQuery) === TRUE) {
        echo "New watched TV Show entry added successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>
