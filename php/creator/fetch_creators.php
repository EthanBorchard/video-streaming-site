<?php
include '../db.php';

$searchText = $conn->real_escape_string($_POST['query']);
$query = "SELECT CreatorID, Name FROM ContentCreator WHERE Name LIKE '$searchText%' LIMIT 10"; 
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<div class='CreatorOption' data-id='" . $row['CreatorID'] . "' data-name='" 
    . htmlspecialchars($row['Name'], ENT_QUOTES) . "'>" . htmlspecialchars($row['Name']) . "</div>";
}
?>
