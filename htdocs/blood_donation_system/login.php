<?php
include 'db.php';
session_start();

// If login form is submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // match encrypted password

    // Check user in DB
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // ✅ Store session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // ✅ Redirect user back to page they wanted
        $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
        unset($_SESSION['redirect_url']); // Clear after use
        header("Location: $redirect_url");
        exit;
    } else {
        $error = "❌ Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<!-- Centered Login Form -->
<div class="admin-container">
    <h2>User Login</h2>
    <form method="POST" action="">
        <!-- Email Input -->
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <!-- Password Input -->
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <!-- Login Button -->
        <button type="submit" name="login">Login</button>
    </form>

    <!-- Error Message -->
    <p>
        <?php if (isset($error)) echo $error; ?>
    </p>
</div>

</body>
</html>
