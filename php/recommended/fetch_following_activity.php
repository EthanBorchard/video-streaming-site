<?php
session_start();
include '../db.php';

$currentUserId = $_SESSION['userid'];

$followedUsersQuery = "SELECT User.UserID, User.Username 
                       FROM Followers
                       JOIN User ON Followers.FollowingUserID = User.UserID
                       WHERE Followers.FollowerUserID = '$currentUserId'
                       ORDER BY RAND() 
                       LIMIT 3";
$followedUsersResult = $conn->query($followedUsersQuery);

$followingActivities = [];
while ($followedUser = $followedUsersResult->fetch_assoc()) {
    $userId = $followedUser['UserID'];
    $followedUserName = $followedUser['Username'];

    $movieQuery = "SELECT Movie.Title, Movie.Year, Movie.Genre, Movie.Duration, MAX(WatchedMovie.WatchCount) as MaxWatchCount 
                   FROM WatchedMovie 
                   JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID 
                   WHERE WatchedMovie.UserID = '$userId' 
                   GROUP BY WatchedMovie.MovieID 
                   ORDER BY MaxWatchCount 
                   DESC LIMIT 1";
    $movieResult = $conn->query($movieQuery);
    $topMovie = $movieResult->fetch_assoc();

    $TVShowQuery = "SELECT TVShow.Title, TVShow.Year, TVShow.Genre, TVShow.Duration, MAX(WatchedTVShow.EpisodesWatched) as MaxEpisodesWatched 
                    FROM WatchedTVShow 
                    JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID 
                    WHERE WatchedTVShow.UserID = '$userId' 
                    GROUP BY WatchedTVShow.TVShowID 
                    ORDER BY MaxEpisodesWatched 
                    DESC LIMIT 1";
    $tvShowResult = $conn->query($TVShowQuery);
    $topTVShow = $tvShowResult->fetch_assoc();

    $creatorQuery = "SELECT ContentCreator.Name, ContentCreator.Followers, MAX(WatchedCreator.HoursWatched) as MaxHoursWatched 
                     FROM WatchedCreator 
                     JOIN ContentCreator ON WatchedCreator.CreatorID = ContentCreator.CreatorID 
                     WHERE WatchedCreator.UserID = '$userId' 
                     GROUP BY WatchedCreator.CreatorID 
                     ORDER BY MaxHoursWatched 
                     DESC LIMIT 1";
    $contentResult = $conn->query($creatorQuery);
    $topCreator = $contentResult->fetch_assoc();

    array_push($followingActivities, [
        'userName' => $followedUserName,
        'topMovie' => $topMovie,
        'topTVShow' => $topTVShow,
        'topCreator' => $topCreator
    ]);
}

echo json_encode($followingActivities);
?>
