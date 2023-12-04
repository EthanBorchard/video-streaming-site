<?php
session_start();
include '../db.php';

$userId = $_SESSION['userid'];
$totalHours = 0;

$movieHoursQuery = "SELECT SUM(Movie.Duration * WatchedMovie.WatchCount) / 60 as TotalMovieHours 
                    FROM WatchedMovie 
                    JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID 
                    WHERE WatchedMovie.UserID = '$userId' 
                    AND YEAR(WatchedMovie.CreatedAt) = 2023";
$movieHoursResult = $conn->query($movieHoursQuery);
if ($row = $movieHoursResult->fetch_assoc()) {
    $totalHours += $row['TotalMovieHours'];
}

$tvShowHoursQuery = "SELECT SUM(TVShow.Duration * WatchedTVShow.EpisodesWatched) / 60 as TotalTVShowHours 
                     FROM WatchedTVShow 
                     JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID 
                     WHERE WatchedTVShow.UserID = '$userId' 
                     AND YEAR(WatchedTVShow.CreatedAt) = 2023";
$tvShowHoursResult = $conn->query($tvShowHoursQuery);
if ($row = $tvShowHoursResult->fetch_assoc()) {
    $totalHours += $row['TotalTVShowHours'];
}

$contentCreatorHoursQuery = "SELECT SUM(WatchedCreator.HoursWatched) as TotalCreatorHours 
                             FROM WatchedCreator 
                             WHERE WatchedCreator.UserID = '$userId' 
                             AND YEAR(WatchedCreator.CreatedAt) = 2023";
$contentCreatorHoursResult = $conn->query($contentCreatorHoursQuery);
if ($row = $contentCreatorHoursResult->fetch_assoc()) {
    $totalHours += $row['TotalCreatorHours'];
}

echo json_encode(round($totalHours, 2));
?>
