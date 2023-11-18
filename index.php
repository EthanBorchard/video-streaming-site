<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="./css/index_style.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <form action="./php/login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>

        <div class="registration-form">
            <h2>Register</h2>
            <form action="./php/register.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="country" placeholder="Country" required>
                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
