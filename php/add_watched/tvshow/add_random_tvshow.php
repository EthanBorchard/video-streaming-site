<?php
session_start();
include '../../db.php';

if (!isset($_SESSION['userid'])) {
    echo "User not logged in";
    exit;
}

$userId = $_SESSION['userid'];
$unique = false;

while (!$unique) {
    $sqlRandomTVShow = "SELECT TVShowID 
                        FROM TVShow 
                        ORDER BY RAND() 
                        LIMIT 1";
    $result = $conn->query($sqlRandomTVShow);
    $row = $result->fetch_assoc();
    $randomTVShowId = $row['TVShowID'];

    $checkQuery = "SELECT * 
                   FROM WatchedTVShow 
                   WHERE UserID = '$userId' 
                   AND TVShowID = '$randomTVShowId'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        $unique = true;
    }
}

$randomEpisodesWatched = rand(1, 60);

$insertQuery = "INSERT INTO WatchedTVShow (UserID, TVShowID, EpisodesWatched) 
                VALUES ('$userId', '$randomTVShowId', '$randomEpisodesWatched')";
if ($conn->query($insertQuery) === TRUE) {
    echo "Random TVShow added successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
