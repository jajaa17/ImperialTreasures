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

// Get the users database
$result = $conn->query("SELECT * FROM users_backup");

if ($result->num_rows > 0) {
    // Proceed to restore
    $user = $result->fetch_assoc();

    // Initialize the fields
    $firstname = $user['firstname'];
    $middlename = $user['middlename'];
    $lastname = $user['lastname'];
    $email = $user['email'];
    $contactno = $user['contactno'];
    $username = $user['username'];
    $password = $user['password'];
    $role = $user['role'];
    $profilepicture = $user['profilepicture'];
    $token = $user['token'];

    // Insert the user data back into the original users table
    $restore_sql = "INSERT INTO users 
                    (firstname, middlename, lastname, email, contactno, username, password, role, profilepicture, token, status) 
                    VALUES ('$firstname', '$middlename', '$lastname', '$email', '$contactno', '$username', '$password', 'user', '$profilepicture', '$token', 'active')";

    $restore_stmt = $conn->prepare($restore_sql);

    if ($restore_stmt->execute()) {
        $delete_backup_sql = "DELETE FROM users_backup WHERE token = ?";
        $delete_backup_stmt = $conn->prepare($delete_backup_sql);
        $delete_backup_stmt->bind_param("s", $token);
        $delete_backup_stmt->execute();
        $delete_backup_stmt->close();
        echo "<script>alert('User has been restored successfully.'); window.location.href = 'trash_bin.php';</script>";
    } else {
        echo "<script>alert('Error restoring user: " . $restore_stmt->error . "'); window.location.href = 'trash_bin.php';</script>";
    }

    $restore_stmt->close();
} else {
    echo "<script>alert('No user found with the provided token in the backup.'); window.location.href = 'trash_bin.php';</script>";
}

$conn->close();
header("Location: trash_bin.php");
exit();
?>