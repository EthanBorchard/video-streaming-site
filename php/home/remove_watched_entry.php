<?php
include '../db.php';
session_start();

if (isset($_POST['watchedId'], $_POST['entryType']) && isset($_SESSION['userid'])) {
    $watchedId = $conn->real_escape_string($_POST['watchedId']);
    $entryType = $_POST['entryType'];
    $userId = $_SESSION['userid'];

    switch ($entryType) {
        case 'movie':
            $table = 'WatchedMovie';
            break;
        case 'tvshow':
            $table = 'WatchedTVShow';
            break;
        case 'creator':
            $table = 'WatchedCreator';
            break;
        default:
            echo "Invalid entry type";
            exit;
    }
    $watchedIdType = $table . 'ID';

    $conn->query("DELETE FROM $table WHERE $watchedIdType = '$watchedId' AND UserID = '$userId'");

} else {
    echo "Invalid request";
}
?>
