<?php
include '../../db.php';

$searchText = $conn->real_escape_string($_POST['query']);
$query = "SELECT TVShowID, Title FROM TVShow WHERE Title LIKE '$searchText%' LIMIT 10"; 
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<div class='TVShowOption' data-id='" . $row['TVShowID'] . "' data-title='" 
    . htmlspecialchars($row['Title'], ENT_QUOTES) . "'>" . htmlspecialchars($row['Title']) . "</div>";
}
?>
