<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="./js/tab_script.js"></script>
</head>

<body>
    <?php
    include './php/db.php';
    session_start();

    $userId = $_SESSION['userid'];
    $query = "SELECT Email, Country FROM User WHERE UserID = '$userId'";
    $result = $conn->query($query);

    if ($row = $result->fetch_assoc()) {
        $email = $row['Email'];
        $country = $row['Country'];
    } else {
    }
    ?>

    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Home')">Home</button>
        <button class="tablinks" onclick="openTab(event, 'AddMovies')">Add Movies</button>
        <button class="tablinks" onclick="openTab(event, 'AddTVShows')">Add TV Shows</button>
        <button class="tablinks" onclick="openTab(event, 'AddContentCreators')">Add Content Creators</button>
        <button class="tablinks" onclick="openTab(event, 'Recommended')">Recommended</button>
        <button class="tablinks" onclick="openTab(event, 'Following')">Following</button>
        <button class="tablinks" onclick="openTab(event, 'Wrapped')">Wrapped</button>
        <button class="tablinks" onclick="openTab(event, 'Account')">Account</button>
    </div>

    <?php include('./php/add_watched/movie/tab_movies.php'); ?>
    <?php include('./php/add_watched/tvshow/tab_tvshows.php'); ?>
    <?php include('./php/add_watched/creator/tab_creators.php'); ?>
    <?php include('./php/recommended/tab_recommended.php'); ?>
    <?php include('./php/following/tab_following.php'); ?>
    <?php include('./php/wrapped/tab_wrapped.php'); ?>
    <?php include('./php/account/tab_account.php'); ?>
    <?php include('./php/home/tab_home.php'); ?>

    <div class="footer">
        <a href="./index.php" class="button">Back</a>
    </div>
</body>
</html>
