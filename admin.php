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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">
    <div class="bg-blur"></div>

    <div class="login-container">

        <form method="POST" action="" class="login-form">

            <h2 class="form-title">Login</h2>


     <div class="login-row">
                <label for="username">Username:</label>
                <input type="username" name="username" id="username" required>
            </div>

            <div class="login-row">      
                <label for="password">Password:</label> 
                <input type="password" name="password" id="password" required> 
    

         <div class="action-button"> 
                <button type="button" id="showPassBtn" onclick="togglePassword()">Show</button> 
            </div>
            </div>
            <button type="submit" name="login">Login</button> 
        
    <a href="index.php" class="back-btn button-style">close</a>

        <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
    </form>

</body>
</html>
