<?php
session_start();
include './db.php';

$userId = $_SESSION['userid'];
$badgesEarned = checkBadgeCriteria($userId, $conn);

function checkBadgeCriteria($userId, $conn) {
    $badges = [
        'firstTimer' => false,
        'noviceWatcher' => false,
        'regularWatcher' => false,
        'bingeWatcher' => false,
        'genreExplorer' => false,
        'movieBuff' => false,
        'seriesMaster' => false,
        'contentKing' => false,
        'socialButterfly' => false,
        'influencer' => false,
    ];


    // First Timer Badge:
    $movieQuery = "SELECT COUNT(*) as count FROM WatchedMovie WHERE UserID = '$userId'";
    $tvShowQuery = "SELECT COUNT(*) as count FROM WatchedTVShow WHERE UserID = '$userId'";
    $contentCreatorQuery = "SELECT COUNT(*) as count FROM WatchedCreator WHERE UserID = '$userId'";

    $movieResult = $conn->query($movieQuery);
    $tvShowResult = $conn->query($tvShowQuery);
    $contentCreatorResult = $conn->query($contentCreatorQuery);

    if ($movieResult->fetch_assoc()['count'] > 0 || 
        $tvShowResult->fetch_assoc()['count'] > 0 || 
        $contentCreatorResult->fetch_assoc()['count'] > 0) {
        $badges['firstTimer'] = true;
    }


    // Novice Watcher, Regular Watcher, and Binge Watcher Badges:
    $totalHours = 0;

    $moviesQuery = "SELECT SUM(Movie.Duration/60 * WatchedMovie.WatchCount) AS TotalMovieHours FROM WatchedMovie 
                    JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID 
                    WHERE WatchedMovie.UserID = '$userId'";
    $moviesResult = $conn->query($moviesQuery);
    if ($row = $moviesResult->fetch_assoc()) {
        $totalHours += $row['TotalMovieHours'];
    }

    $tvShowsQuery = "SELECT SUM(TVShow.Duration/60 * WatchedTVShow.EpisodesWatched) AS TotalTVShowHours FROM WatchedTVShow 
                     JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID 
                     WHERE WatchedTVShow.UserID = '$userId'";
    $tvShowsResult = $conn->query($tvShowsQuery);
    if ($row = $tvShowsResult->fetch_assoc()) {
        $totalHours += $row['TotalTVShowHours'];
    }

    $creatorsQuery = "SELECT SUM(HoursWatched) AS TotalCreatorHours FROM WatchedCreator WHERE UserID = '$userId'";
    $contentCreatorsResult = $conn->query($creatorsQuery);
    if ($row = $contentCreatorsResult->fetch_assoc()) {
        $totalHours += $row['TotalCreatorHours'];
    }

    if ($totalHours >= 1000) {
        $badges['noviceWatcher'] = true;
    }
    if ($totalHours >= 5000) {
        $badges['regularWatcher'] = true;
    }
    if ($totalHours >= 10000) {
        $badges['bingeWatcher'] = true;
    }


    // Genre Explorer Badge:
    $genres = [];
    $movieGenresQuery = "SELECT DISTINCT Genre FROM Movie 
                         JOIN WatchedMovie ON Movie.MovieID = WatchedMovie.MovieID 
                         WHERE WatchedMovie.UserID = '$userId'";
    $tvShowGenresQuery = "SELECT DISTINCT Genre FROM TVShow 
                          JOIN WatchedTVShow ON TVShow.TVShowID = WatchedTVShow.TVShowID 
                          WHERE WatchedTVShow.UserID = '$userId'";

    $movieGenresResult = $conn->query($movieGenresQuery);
    while ($row = $movieGenresResult->fetch_assoc()) {
        $genres = array_merge($genres, explode('/', $row['Genre']));
    }

    $tvShowGenresResult = $conn->query($tvShowGenresQuery);
    while ($row = $tvShowGenresResult->fetch_assoc()) {
        $genres = array_merge($genres, explode('/', $row['Genre']));
    }

    $uniqueGenres = array_unique($genres);

    if (count($uniqueGenres) >= 15) {
        $badges['genreExplorer'] = true;
        $badges['genreCount'] = count($uniqueGenres);
    }


    // Movie Buff Badge:
    $movieCountQuery = "SELECT COUNT(DISTINCT MovieID) as movieCount FROM WatchedMovie WHERE UserID = '$userId'";
    $movieCountResult = $conn->query($movieCountQuery);
    if ($movieCountResult->fetch_assoc()['movieCount'] >= 20) {
        $badges['movieBuff'] = true;
    }


    // Series Master Badge:
    $tvShowCountQuery = "SELECT COUNT(DISTINCT TVShowID) as tvShowCount FROM WatchedTVShow WHERE UserID = '$userId'";
    $tvShowCountResult = $conn->query($tvShowCountQuery);
    if ($tvShowCountResult->fetch_assoc()['tvShowCount'] >= 20) {
        $badges['seriesMaster'] = true;
    }


    // Content King Badge:
    $creatorCountQuery = "SELECT COUNT(DISTINCT CreatorID) as creatorCount FROM WatchedCreator WHERE UserID = '$userId'";
    $creatorCountResult = $conn->query($creatorCountQuery);
    if ($creatorCountResult->fetch_assoc()['creatorCount'] >= 20) {
        $badges['contentKing'] = true;
    }


    // Social Butterfly Badge:
    $followingCountQuery = "SELECT COUNT(DISTINCT FollowingUserID) as followingCount FROM Followers WHERE FollowerUserID = '$userId'";
    $followingCountResult = $conn->query($followingCountQuery);
    if ($followingCountResult->fetch_assoc()['followingCount'] >= 10) {
        $badges['socialButterfly'] = true;
    }


    // Influencer Badge:
    $followerCountQuery = "SELECT COUNT(DISTINCT FollowerUserID) as followerCount FROM Followers WHERE FollowingUserID = '$userId'";
    $followerCountResult = $conn->query($followerCountQuery);
    if ($followerCountResult->fetch_assoc()['followerCount'] >= 10) {
        $badges['influencer'] = true;
    }

    
    return $badges;
}

echo json_encode($badgesEarned);