<?php
// customer_dashboard.php
session_start();
include 'db.php'; // make sure db.php path is correct

// Redirect if not logged in or not a customer
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

// Ensure we have a user name to display
$user_name = null;
if (!empty($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
} else {
    // Fallback: fetch from DB using user_id (defensive)
    $user_id = intval($_SESSION['user_id']);
    $res = mysqli_query($conn, "SELECT name FROM users WHERE id = $user_id LIMIT 1");
    if ($res && mysqli_num_rows($res) === 1) {
        $row = mysqli_fetch_assoc($res);
        $user_name = $row['name'];
        // store back to session for future requests
        $_SESSION['user_name'] = $user_name;
    } else {
        $user_name = "Customer";
    }
}

// Optional: sanitize for output
function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard | AgroTradeHub</title>
    <link rel="stylesheet" href="style.css"> <!-- keep your existing css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">
    <h2>👩‍🌾 Welcome, <?php echo h($user_name); ?>!</h2>
    <p class="sub-text">Select an option below to browse products, place orders, or leave reviews.</p>

    <div class="dashboard-grid">

        <!-- Browse Products -->
        <a href="products.php" class="dash-box">
            <i class="fa fa-leaf"></i>
            <h3>Browse Products</h3>
            <p>Explore fresh fruits, vegetables, seeds, and trees</p>
        </a>

        <!-- My Cart -->
        <a href="cart.php" class="dash-box">
            <i class="fa fa-shopping-cart"></i>
            <h3>My Cart</h3>
            <p>View and manage items before checkout</p>
        </a>

         <a href="order_confirmation.php" class="dash-box">
            <i class="fa fa-leaf"></i>
            <h3>My Order</h3>
            <p>Check your Orders</p>
        </a>

        <!-- My Reviews -->
        <a href="reviews.php" class="dash-box">
            <i class="fa fa-star"></i>
            <h3>My Reviews</h3>
            <p>Share your feedback on purchased products</p>
        </a>

        <!-- Profile Settings -->
        <a href="profile.php" class="dash-box">
            <i class="fa fa-user-cog"></i>
            <h3>Profile Settings</h3>
            <p>Update personal information and password</p>
        </a>

    </div>
</div>

</body>
</html>
