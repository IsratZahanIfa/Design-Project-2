<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'customer')
     {
    header("Location: login.php");
    exit();
}

$user_name = null;
if (!empty($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
} else {

    $user_id = intval($_SESSION['user_id']);
    $res = mysqli_query($conn, "SELECT name FROM users WHERE id = $user_id LIMIT 1");
    if ($res && mysqli_num_rows($res) === 1) {
        $row = mysqli_fetch_assoc($res);
        $user_name = $row['name'];
  
        $_SESSION['user_name'] = $user_name;
    } else {
        $user_name = "Customer";
    }
}

function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard | AgroTradeHub</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">
    <h2>👩‍🌾 Welcome, <?php echo h($user_name); ?>!</h2>
    <p class="sub-text">Select an option below to browse products, place orders, or leave reviews.</p>

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

    <div>
         <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
</dive>

</div>

</body>
</html>
