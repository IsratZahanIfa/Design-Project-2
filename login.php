<?php 
include 'db.php'; 
session_start(); 
if (isset($_POST['login'])) 
{ 
    $email = $_POST['email']; 
    $password = md5($_POST['password']); 
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'"); 
    
    if (mysqli_num_rows($result) == 1) 
    { 
        $user = mysqli_fetch_assoc($result); 
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['user_name'] = $user['name']; 
        $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'customer') 
    { 
        header("Location: customer_dashboard.php"); 
    } 
    elseif ($user['role'] == 'seller') 
        { 
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-body">
    <div class="bg-blur"></div>

    <div class="login-container">

        <form method="POST" action="" class="login-form">

            <h2 class="form-title">Login</h2>

            <div class="login-row">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
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

            <p class="register-link">
                Don't have an account? <a href="register.php">Register</a>
            </p>

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


        

    