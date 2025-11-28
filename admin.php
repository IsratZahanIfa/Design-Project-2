<?php
session_start();

// FIXED ADMIN CREDENTIALS
$fixedUsername = "admin";
$fixedPassword = "admin123";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $fixedUsername && $password === $fixedPassword) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "❌ Invalid username or password!";
    }
}

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin'])) {
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

    <form class="login-container" method="POST" action="">
        <h2>Login</h2>

       <label>Username:</label>
        <input type="username" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" name="login">Login</button>
        
    <a href="index.php" class="back-btn button-style">Back</a>

        <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
    </form>

</body>
</html>
