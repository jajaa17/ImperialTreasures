<?php
session_start();

// Check if user is logged in and is admin
if (!(isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin')) {
    header("Location: login.php"); // Redirect to login if not logged in as admin
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "websys_final";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($statement = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?")) {

        $statement->bind_param("i", $param_id);

        $param_id = $_POST["user_id"];

        if ($statement->execute()) {
            header("Location: admin_page.php");
            exit();
        } else {
            echo "Error enabling user.";
        }

        $statement->close();
    }

    $conn->close();
} else {
    header("Location: admin_page.php");
    exit();
}
?>
