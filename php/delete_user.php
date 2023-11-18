<?php
include './db.php';
session_start();

$userId = $_POST['userId'] ?? null;

if ($userId && $userId == $_SESSION['userid']) {
    $conn->query("DELETE FROM WatchedMovie WHERE UserID = '$userId'");
    $conn->query("DELETE FROM WatchedTVShow WHERE UserID = '$userId'");
    $conn->query("DELETE FROM WatchedCreator WHERE UserID = '$userId'");

    $conn->query("DELETE FROM User WHERE UserID = '$userId'");

    session_destroy();

    echo "User deleted successfully.";
} else {
    http_response_code(403);
    echo "Error: Unauthorized request";
}
?>
