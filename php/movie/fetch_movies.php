<?php
include '../db.php';

$searchText = $conn->real_escape_string($_POST['query']);
$query = "SELECT MovieID, Title FROM Movie WHERE Title LIKE '$searchText%' LIMIT 10"; 
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<div class='movieOption' data-id='" . $row['MovieID'] . "' data-title='" 
    . htmlspecialchars($row['Title'], ENT_QUOTES) . "'>" . htmlspecialchars($row['Title']) . "</div>";
}
?>
