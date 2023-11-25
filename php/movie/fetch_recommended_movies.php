<?php
session_start();
include '../db.php';

$userId = $_SESSION['userid'];

$topGenresQuery = "SELECT Movie.Genre, COUNT(*) as genre_count 
                   FROM WatchedMovie 
                   JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID 
                   WHERE WatchedMovie.UserID = '$userId' 
                   GROUP BY Movie.Genre 
                   ORDER BY genre_count DESC LIMIT 2";
$topGenresResult = $conn->query($topGenresQuery);

$topGenres = [];
while ($row = $topGenresResult->fetch_assoc()) {
    array_push($topGenres, $row['Genre']);
}

$recommendedMovies = [];
foreach ($topGenres as $genre) {
    if (count($recommendedMovies) >= 3) break;

    $movieQuery = "SELECT Movie.Title, Movie.Genre, StreamingService.Name as ServiceName 
                   FROM Movie 
                   JOIN StreamingService ON Movie.ServiceID = StreamingService.ServiceID 
                   WHERE Movie.Genre LIKE '%$genre%' AND Movie.MovieID NOT IN 
                   (SELECT MovieID FROM WatchedMovie WHERE UserID = '$userId') 
                   LIMIT 3";

    $movieResult = $conn->query($movieQuery);
    while ($row = $movieResult->fetch_assoc()) {
        if (count($recommendedMovies) < 3) {
            array_push($recommendedMovies, [
                'title' => $row['Title'],
                'genre' => $row['Genre'],
                'streamingService' => $row['ServiceName']
            ]);
        }
    }
}

echo json_encode($recommendedMovies);
