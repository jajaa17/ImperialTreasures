<!-- TEMPORARY REGISTER HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <main>
        <h2>Create an Account</h2>
        <form action="registerSQL.php" method="post" onsubmit="return validatePassword();">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="middlename">Middle Name</label>
            <input type="text" id="middlename" name="middlename">

            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="contactno">Contact Number</label>
            <input type="text" id="contactno" name="contactno" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <button type="submit">Register</button>
            <p class="form-switch text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </main>
</body>

</html>