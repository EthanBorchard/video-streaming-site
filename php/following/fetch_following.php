<?php
session_start();
include '../db.php';

$currentUserId = $_SESSION['userid'];

$query = "SELECT User.Username, User.Country, DATE_FORMAT(Followers.CreatedAt, '%m/%d/%Y') as Since FROM Followers
          JOIN User ON Followers.FollowingUserID = User.UserID
          WHERE Followers.FollowerUserID = '$currentUserId'";

$result = $conn->query($query);

$followingUsers = [];
while ($row = $result->fetch_assoc()) {
    array_push($followingUsers, $row);
}

echo json_encode($followingUsers);
?>
