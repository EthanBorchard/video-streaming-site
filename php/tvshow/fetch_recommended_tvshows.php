<?php
session_start();
include '../db.php';

$userId = $_SESSION['userid'];

$topGenresQuery = "SELECT TVShow.Genre, COUNT(*) as genre_count 
                   FROM WatchedTVShow 
                   JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID 
                   WHERE WatchedTVShow.UserID = '$userId' 
                   GROUP BY TVShow.Genre 
                   ORDER BY genre_count DESC LIMIT 2";
$topGenresResult = $conn->query($topGenresQuery);

$topGenres = [];
while ($row = $topGenresResult->fetch_assoc()) {
    array_push($topGenres, $row['Genre']);
}

$recommendedTVShows = [];
foreach ($topGenres as $genre) {
    if (count($recommendedTVShows) >= 3) break;

    $TVShowQuery = "SELECT TVShow.Title, TVShow.Genre, StreamingService.Name as ServiceName 
                   FROM TVShow 
                   JOIN StreamingService ON TVShow.ServiceID = StreamingService.ServiceID 
                   WHERE TVShow.Genre LIKE '%$genre%' AND TVShow.TVShowID NOT IN 
                   (SELECT TVShowID FROM WatchedTVShow WHERE UserID = '$userId') 
                   LIMIT 3";

    $TVShowResult = $conn->query($TVShowQuery);
    while ($row = $TVShowResult->fetch_assoc()) {
        if (count($recommendedTVShows) < 3) {
            array_push($recommendedTVShows, [
                'title' => $row['Title'],
                'genre' => $row['Genre'],
                'streamingService' => $row['ServiceName']
            ]);
        }
    }
}

echo json_encode($recommendedTVShows);
