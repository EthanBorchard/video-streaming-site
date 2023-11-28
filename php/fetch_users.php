<?php
session_start();
include './db.php';

$searchText = $_POST['searchText'] ?? '';
$currentUserId = $_SESSION['userid'];

$query = "SELECT UserID, Username FROM User WHERE Username LIKE '%$searchText%' 
          AND UserID != '$currentUserId' LIMIT 10";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<div class='user-search-result'>";
    echo "<p>" . htmlspecialchars($row['Username']) . "</p>";
    echo "<button class='follow-btn' data-userid='" . $row['UserID'] . "' data-username='" 
          . htmlspecialchars($row['Username']) . "'>Follow</button>";
    echo "</div>";
}
?>
