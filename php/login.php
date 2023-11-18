<?php
include './db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT UserID, Username, Password FROM User WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['Password']) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['UserID'];
            $_SESSION['username'] = $username;

            $_SESSION['welcome_message'] = "Welcome back, " . htmlspecialchars($username) . "!";
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username does not exist.";
    }

    $conn->close();
}
?>
