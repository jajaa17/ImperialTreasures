<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websys_final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user_id from the POST request
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Fetch the user's current data
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Insert the user data into the backup table
        $backup_sql = "INSERT INTO users_backup
                       (firstname, middlename, lastname, contactno, email, username, role, profilepicture, token) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $backup_stmt = $conn->prepare($backup_sql);
        $backup_stmt->bind_param(
            "sssssssss",
            $user['firstname'],
            $user['middlename'],
            $user['lastname'],
            $user['contactno'],
            $user['email'],
            $user['username'],
            $user['role'],
            $user['profilepicture'],
            $user['token']
        );

        if ($backup_stmt->execute()) {
            $delete_sql = "DELETE FROM users WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $user_id);
            if ($delete_stmt->execute()) {
                echo "<script>alert('User has been moved to trash.'); window.location.href = 'admin_page.php';</script>";
            } else {
                echo "Error removing user: " . $delete_stmt->error;
            }
            $delete_stmt->close();
        } else {
            echo "Error backing up user: " . $backup_stmt->error;
        }

        $backup_stmt->close();
    } else {
        echo "<script>alert('No user found with this ID.'); window.location.href = 'admin_page.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No user ID provided.'); window.location.href = 'admin_page.php';</script>";
}

$conn->close();
header("Location: admin_page.php");
exit();
?>
