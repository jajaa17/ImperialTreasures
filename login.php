<!-- Php for accessing the main page -->
<?php
session_start();
// If user is already logged in, redirect to index or welcome_message
if (isset($_SESSION['user_id'])) {
    header("Location: welcome_message.php");
    exit();
}
?>

<!-- HTML Document -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <!-- Basic Login Form w/ Sign up -->
    <main>
        <form action="loginSQL.php" method="post">
            <label for="username-value">Username:</label><br>
            <input type="text" id="username-value" name="username" required><br>
            <label for="password-value">Password:</label><br>
            <input type="password" id="password-value" name="password" required><br><br>
            <input type="submit" value="Login">
            <p class="form-switch text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
            <p class="form-switch text-center mt-3">Recover your account? <a href="">Recover account</a></p>
        </form>
    </main>

    <!-- Error Handling -->
    <?php
    if (isset($_SESSION['login_error'])) {
        echo $_SESSION['login_error'];
        unset($_SESSION['login_error']);
    }
    ?>

</body>

</html>