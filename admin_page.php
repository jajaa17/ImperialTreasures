<!-- MySQL Connection -->
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

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$conn->close();
?>

<!-- CUSTOM ADMIN PAGE (CHANGE WHEN ADMIN PAGE IS DONE) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th>Profile Picture</th>
                <th>Token</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['firstname'] . "</td>";
                    echo "<td>" . $row['middlename'] . "</td>";
                    echo "<td>" . $row['lastname'] . "</td>";
                    echo "<td>" . $row['contactno'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    echo "<td>";
                    if ($row['status'] === 'active') {
                        echo "<span class='status-active'>Active</span>";
                    } else {
                        echo "<span class='status-disabled'>Disabled</span>";
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($row['profilepicture']) {
                        echo '<img src="uploads/' . $row['profilepicture'] . '" alt="Profile Picture" class="profile-picture">';
                    } else {
                        echo "No image";
                    }
                    echo "</td>";
                    echo "<td>" . $row['token'] . "</td>";
                    echo "<td class='action-buttons'>";

                    echo "<form action='trash_user.php' method='post' onsubmit='return confirmAction(\"trash\")'>";
                    echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' btn-sm'>Move to Bin</button>";
                    echo "</form>";
                    
                    if ($row['status'] === 'active') {
                        echo "<form action='disable_user.php' method='post' onsubmit='return confirmAction(\"disable\")'>";
                        echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='status' value='disabled'>";
                        echo "<button type='submit'>Disable</button>";
                        echo "</form>";
                    } elseif ($row['status'] === 'inactive') {
                        echo "<form action='enable_user.php' method='post' onsubmit='return confirmAction(\"enable\")'>";
                        echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='status' value='active'>";
                        echo "<button type='submit'>Enable</button>";
                        echo "</form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11' class='text-center'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Logout button -->
    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<li><a href="logoutSQL.php">Logout</a></li>';
        echo '<li><a href="trash_bin.php">Trash Bin</a></li>';
    }
    ?>
    

</body>

</html>