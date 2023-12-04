<?php
session_start();
include './db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $email = $conn->real_escape_string($_POST['email']);
    $country = $conn->real_escape_string($_POST['country']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO User (Username, Password, Email, Country) 
            VALUES ('$username', '$hashedPassword', '$email', '$country')";

    if ($conn->query($sql) === TRUE) {
        $sql2 = "SELECT UserID, Username FROM User WHERE Username = '$username'";
        $result = $conn->query($sql2);
        $row = $result->fetch_assoc();

        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $row['UserID'];
        $_SESSION['username'] = $username;

        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
