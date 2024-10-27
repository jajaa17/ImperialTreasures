<!-- MySQL connection -->
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websys_final";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if ($user['status'] === 'active') {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['middlename'] = $user['middlename'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['email']; 
                $_SESSION['contactno'] = $user['contactno']; 
                $_SESSION['role'] = $user['role'];
                $_SESSION['token'] = $user['token'];

                // Debugging statements
                echo "User role: " . $_SESSION['role'] . "<br>";
                echo "User ID: " . $_SESSION['user_id'] . "<br>";
                echo "Redirecting...<br>";

                //Differentiates between admin and user
                if ($_SESSION['role'] === 'admin') {
                    echo "Redirecting to admin_page.php";
                    header("Location: admin_page.php");
                    exit();
                } else {
                    echo "Redirecting to welcome_message.php";
                    header("Location: welcome_message.php");
                    exit();
                }

            } else {
                $_SESSION['login_error'] = "Invalid username or password. Please try again.";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['login_error'] = "Your account is currently disabled. Please contact an administrator.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Invalid username or password. Please try again.";
        header("Location: login.php");
        exit();
    }
}

$conn->close();
?>
