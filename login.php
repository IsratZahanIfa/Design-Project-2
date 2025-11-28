<?php
include 'db.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Store session data
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role']     = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'customer') {
            header("Location: customer_dashboard.php");
        } 
        elseif ($user['role'] == 'seller') {
            header("Location: seller_dashboard.php");
        } 
        else {
            header("Location: index.php");
        }
        exit;
    } 
    else {
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
<body class="admin-body">

<div class="login-container">
    <h2>User Login</h2>

    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>

        <div class="action-row">
            <button type="button" id="showPassBtn" onclick="togglePassword()">Show</button>
            <a href="forget_password.php" class="forget-inline">Forget Password?</a>
        </div>

        <button type="submit" name="login">Login</button>

        <a href="index.php" class="back-btn">Back</a>
    </form>

    <p><?php if(isset($error)) echo $error; ?></p>
</div>

<script>
function togglePassword() {
    var pass = document.getElementById("password");
    var btn  = document.getElementById("showPassBtn");

    if (pass.type === "password") {
        pass.type = "text";
        btn.textContent = "Hide";
    } else {
        pass.type = "password";
        btn.textContent = "Show";
    }
}
</script>

</body>
</html>
