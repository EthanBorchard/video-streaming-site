<?php
session_start();
include '../db.php';

$userId = $_SESSION['userid'];

$topTVShowQuery = "SELECT TVShow.Title, SUM(WatchedTVShow.EpisodesWatched) as TotalWatchCount 
                  FROM WatchedTVShow
                  JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID 
                  WHERE WatchedTVShow.UserID = '$userId' AND YEAR(WatchedTVShow.CreatedAt) = 2023 
                  GROUP BY TVShow.TVShowID 
                  ORDER BY TotalWatchCount DESC 
                  LIMIT 1";

$result = $conn->query($topTVShowQuery);
if ($result->num_rows > 0) {
    $topTVShow = $result->fetch_assoc();
    echo json_encode($topTVShow);
} else {
    echo json_encode(null);
}
?>
