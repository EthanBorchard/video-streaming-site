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
        <button class="tablinks" onclick="openTab(event, 'Account')">Account</button>
    </div>

    <?php include('./php/movie/tab_movies.php'); ?>
    <?php include('./php/tvshow/tab_tvshows.php'); ?>
    <?php include('./php/creator/tab_creators.php'); ?>
    <?php include('./php/tab_account.php'); ?>
    <?php include('./php/tab_home.php'); ?>

    <div class="footer">
        <a href="./index.php" class="button">Back</a>
    </div>
</body>
</html>
