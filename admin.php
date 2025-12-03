<?php
session_start();

$fixedUsername = "admin";
$fixedemail = "admin";
$fixedPassword = "admin123";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $mail = trim($_POST['email']);
    $password = trim($_POST['password']);


    if ($username === $fixedUsername && $password === $fixedPassword) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}

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
                <a href="#" class="forget-inline">Forget Password?</a>
            </div>
    </div>
            <button type="submit" name="login">Login</button> 

            <?php if(isset($error)) { ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php } ?>

        </form>

    </div> 
    
    <script>
        function togglePassword() { 
            var pass = document.getElementById("password"); 
            var btn = document.getElementById("showPassBtn"); 
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
