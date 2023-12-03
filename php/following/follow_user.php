<?php
session_start();
include '../db.php';

$followerUserId = $_SESSION['userid'];
$followedUserId = $_POST['followedUserId'];

$checkQuery = "SELECT * FROM Followers WHERE FollowerUserID = '$followerUserId' 
               AND FollowingUserID = '$followedUserId'";
$checkResult = $conn->query($checkQuery);
if ($checkResult->num_rows > 0) {
    echo 'already_following';
    exit;
}

$insertQuery = "INSERT INTO Followers (FollowerUserID, FollowingUserID) 
                VALUES ('$followerUserId', '$followedUserId')";
if ($conn->query($insertQuery) === TRUE) {
    echo 'success';
} else {
    echo 'error';
}
?>
