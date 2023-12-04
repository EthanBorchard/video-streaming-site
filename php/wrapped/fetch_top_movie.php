<?php
session_start();
include '../db.php';

$userId = $_SESSION['userid'];

$topMovieQuery = "SELECT Movie.MovieID, Movie.Title, SUM(WatchedMovie.WatchCount) as TotalWatchCount 
                  FROM WatchedMovie 
                  JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID 
                  WHERE WatchedMovie.UserID = '$userId' 
                  AND YEAR(WatchedMovie.CreatedAt) = 2023 
                  GROUP BY Movie.MovieID 
                  ORDER BY TotalWatchCount 
                  DESC LIMIT 1";

$result = $conn->query($topMovieQuery);
if ($result->num_rows > 0) {
    $topMovie = $result->fetch_assoc();
    echo json_encode($topMovie);
} else {
    echo json_encode(null);
}
?>
