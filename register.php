<?php
include 'db.php';

// Check if the Register button was clicked
if (isset($_POST['register'])) {

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']);
    $contact  = $_POST['contact'];
    $role     = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, contact, role) 
            VALUES ('$name', '$email', '$password', '$contact', '$role')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?success=1");
        exit;
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="admin-body">
    
<div class="bg-blur"></div>
    <div class="admin-container">

        <form method="POST" action="" class="registration-form">

            <h2 class="form-title">Sign Up Your Account!</h2>

            <div class="form-row">
                <label>Full Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-row">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-row">
                <label>Create Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-row">
                <label>Contact Number</label>
                <input type="text" name="contact">
            </div>

            <div class="form-row">
                <label>Select Role</label>
                <select name="role" id="role" required>
                    <option value="seller">Seller</option>
                    <option value="customer">Customer</option>
                </select>
            </div>

            

           <button type="submit" name="register">Register</button>
            <a href="index.php" class="back-btn button-style">Back</a>
           
        </form>
    </div>


</body>
</html>
