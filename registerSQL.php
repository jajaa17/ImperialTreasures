<?php
session_start();

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "websys_final";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$middlename = mysqli_real_escape_string($conn, $_POST['middlename']); 
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$contactno = mysqli_real_escape_string($conn, $_POST['contactno']); 
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

// Check if any field is empty
if (empty($firstname) || empty($lastname) || empty($email) || empty($contactno) || empty($username) || empty($password) || empty($confirm_password)) {
    echo "<script>alert('All fields are required.'); window.location.href = 'register.php';</script>";
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format.'); window.location.href = 'register.php';</script>";
    exit();
}

// Check if passwords match
if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match.'); window.location.href = 'register.php';</script>";
    exit();
}

// Check if username or email already exists
$sql_check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "<script>alert('Username or email already exists.'); window.location.href = 'register.php';</script>";
    exit();
}

//token generator
$token = bin2hex(random_bytes(3)) . dechex(time());

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$sql_insert = "INSERT INTO users (firstname, middlename, lastname, email, contactno, username, password, role, status, token)
               VALUES ('$firstname', '$middlename', '$lastname', '$email', '$contactno', '$username', '$hashed_password', 'user', 'active', '$token')";

if ($conn->query($sql_insert) === TRUE) {
    echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
    exit();
} else {
    echo "<script>alert('Error: " . $sql_insert . "\\n" . $conn->error . "'); window.location.href = 'register.php';</script>";
    exit();
}

$conn->close();
?>
