<?php
session_start();
include './db.php';

$searchText = $_POST['searchText'] ?? '';
$currentUserId = $_SESSION['userid'];

$query = "SELECT UserID, Username FROM User WHERE Username LIKE '%$searchText%' 
          AND UserID != '$currentUserId' LIMIT 6";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $userId = $row['UserID'];

    $followCheckQuery = "SELECT * FROM Followers WHERE FollowerUserID = '$currentUserId' AND FollowingUserID = '$userId'";
    $followCheckResult = $conn->query($followCheckQuery);
    $isFollowing = $followCheckResult->num_rows > 0;

    echo "<div class='user-search-result'>";
    echo "<p>" . htmlspecialchars($row['Username']) . "</p>";
    if ($isFollowing) {
        echo "<button class='unfollow-btn' data-userid='" . $userId . "'>Unfollow</button>";
    } else {
        echo "<button class='follow-btn' data-userid='" . $userId . "'>Follow</button>";
    }
    echo "</div>";
}
?>
