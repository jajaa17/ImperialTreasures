<!-- CUSTOM INDEX PAGE (CHANGE WHEN HOME PAGE IS DONE) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Message</title>
</head>

<body>
    <h1>
        <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                $user = $_SESSION['username'];
                echo "<h2>Hello, $user</h2>";
            } else {
                echo '<h2>HERESY</h2>';
            }
        ?>
    </h1>

    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<li><a href="logoutSQL.php">Logout</a></li>';
    } else {
        echo '<li><a href="login.php">Login</a></li>';
        echo '<li><a href="register.php">Register</a></li>';
    }
    ?>
</body>

</html>