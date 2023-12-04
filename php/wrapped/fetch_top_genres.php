<?php
session_start();
include '../db.php';

$userId = $_SESSION['userid'];
$genres = [];

$movieGenresQuery = "SELECT Genre 
                     FROM WatchedMovie 
                     JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID 
                     WHERE WatchedMovie.UserID = '$userId' 
                     AND YEAR(WatchedMovie.CreatedAt) = 2023";

$movieGenresResult = $conn->query($movieGenresQuery);
while ($row = $movieGenresResult->fetch_assoc()) {
    $genres = array_merge($genres, explode('/', $row['Genre']));
}

$tvShowGenresQuery = "SELECT Genre 
                      FROM WatchedTVShow 
                      JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID 
                      WHERE WatchedTVShow.UserID = '$userId' 
                      AND YEAR(WatchedTVShow.CreatedAt) = 2023";
                      
$tvShowGenresResult = $conn->query($tvShowGenresQuery);
while ($row = $tvShowGenresResult->fetch_assoc()) {
    $genres = array_merge($genres, explode('/', $row['Genre']));
}

$genreCounts = array_count_values($genres);
arsort($genreCounts);
$topGenres = array_slice(array_keys($genreCounts), 0, 5);

echo json_encode($topGenres);
?>
