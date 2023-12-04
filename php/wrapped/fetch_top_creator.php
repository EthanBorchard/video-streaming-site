<?php
session_start();
include '../db.php';

$userId = $_SESSION['userid'];

$topCreatorQuery = "SELECT ContentCreator.CreatorID, ContentCreator.Name, Sum(WatchedCreator.HoursWatched) as TotalWatchCount 
                    FROM WatchedCreator 
                    JOIN ContentCreator ON WatchedCreator.CreatorID = ContentCreator.CreatorID 
                    WHERE WatchedCreator.UserID = '$userId' 
                    AND YEAR(WatchedCreator.CreatedAt) = 2023 
                    GROUP BY ContentCreator.CreatorID 
                    ORDER BY TotalWatchCount 
                    DESC LIMIT 1";

$result = $conn->query($topCreatorQuery);
if ($result->num_rows > 0) {
    $topCreator = $result->fetch_assoc();
    echo json_encode($topCreator);
} else {
    echo json_encode(null);
}
?>
