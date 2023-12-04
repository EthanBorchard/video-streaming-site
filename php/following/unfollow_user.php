<?php
session_start();
include '../db.php';

$followerUserId = $_SESSION['userid'];
$followingUserId = $_POST['followingUserId'];

$unfollowQuery = "DELETE FROM Followers 
                  WHERE FollowerUserID = '$followerUserId' 
                  AND FollowingUserID = '$followingUserId'";
if ($conn->query($unfollowQuery) === TRUE) {
    echo 'success';
} else {
    echo 'error';
}
?>
