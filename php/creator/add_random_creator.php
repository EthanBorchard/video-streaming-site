<?php
session_start();
include '../db.php';

if (!isset($_SESSION['userid'])) {
    echo "User not logged in";
    exit;
}

$userId = $_SESSION['userid'];
$unique = false;

while (!$unique) {
    $sqlRandomCreator = "SELECT CreatorID FROM ContentCreator ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sqlRandomCreator);
    $row = $result->fetch_assoc();
    $randomCreatorId = $row['CreatorID'];

    $checkQuery = "SELECT * FROM WatchedCreator WHERE UserID = '$userId' AND CreatorID = '$randomCreatorId'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        $unique = true;
    }
}

$randomHoursWatched = rand(1, 200);

$insertQuery = "INSERT INTO WatchedCreator (UserID, CreatorID, HoursWatched) VALUES ('$userId', '$randomCreatorId', '$randomHoursWatched')";
if ($conn->query($insertQuery) === TRUE) {
    echo "Random creator entry added successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
