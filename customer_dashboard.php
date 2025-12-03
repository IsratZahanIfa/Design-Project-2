<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$uid = intval($_SESSION['user_id']); 

// Fetch customer info (You used sellers table, not customer table)
$sql = "SELECT name, email, contact, created_at 
        FROM sellers 
        WHERE user_id = ? 
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) === 1) {
    $customer = mysqli_fetch_assoc($result);
} else {
    $customer = null;
}

mysqli_stmt_close($stmt);

// HTML escape function
function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// FIXED VARIABLES
$customer_name    = $customer['name'] ?? 'Customer';
$customer_email   = $customer['email'] ?? 'Not Provided';
$customer_contact = $customer['contact'] ?? 'Not Provided';
$customer_joined  = !empty($customer['created_at']) 
                    ? date("F j, Y", strtotime($customer['created_at'])) 
                    : 'Not Recorded';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard | AgroTradeHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
       body { 
            margin:0; 
            padding:0; 
            font-family:'Poppins',sans-serif; 
            background: url('https://t3.ftcdn.net/jpg/15/20/56/68/360_F_1520566864_eotnOsoKbNWuQlKPXPRzDqKz0II1jARE.jpg') 
                       no-repeat center center/cover; 
            background-size: 150%;   
        }
    </style>
</head>

<body>
<div class="page">

    <div class="header">
        <div class="profile-card">
            <img src="https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg">
            <div class="profile-info">
                <h3><?= h($customer_name) ?></h3>
                <p>Email: <?= h($customer_email) ?></p>
                <p>Contact: <?= h($customer_contact) ?></p>
                <p style="font-size:12px;color:#666;">Joined: <?= h($customer_joined) ?></p>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">

        <a href="products.php" class="dash-box">
            <i class="fa fa-leaf"></i>
            <h3>Browse Products</h3>
            <p>তাজা ফল, শাকসবজি, বীজ এবং গাছ অন্বেষণ করুন</p>
        </a>

        <a href="cart.php" class="dash-box">
            <i class="fa fa-shopping-cart"></i>
            <h3>My Cart</h3>
            <p>চেকআউটের আগে আইটেমগুলি দেখুন এবং পরিচালনা করুন</p>
        </a>

        <a href="order_confirmation.php" class="dash-box">
            <i class="fa fa-leaf"></i>
            <h3>My Order</h3>
            <p>আপনার অর্ডার চেক করুন</p>
        </a>

        <a href="reviews.php" class="dash-box">
            <i class="fa fa-star"></i>
            <h3>My Reviews</h3>
            <p>কেনা পণ্য সম্পর্কে আপনার মতামত শেয়ার করুন</p>
        </a>

        <a href="profile.php" class="dash-box">
            <i class="fa fa-user-cog"></i>
            <h3>Profile Settings</h3>
            <p>ব্যক্তিগত তথ্য এবং পাসওয়ার্ড আপডেট করুন</p>
        </a>

    </div>

    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

</div>
</body>
</html>
