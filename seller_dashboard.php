<?php
// seller_dashboard.php
session_start();
include 'db.php'; 

// Redirect if not logged in or not a seller
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

// Fetch seller info (only existing columns)
$user_id = intval($_SESSION['user_id']);
$res = mysqli_query($conn, "SELECT id, name, email, contact, created_at, role FROM users WHERE id = $user_id LIMIT 1");
$seller = mysqli_fetch_assoc($res);

// Safe output helper
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard | AgroTradeHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin:0; padding:0; font-family: 'Poppins', sans-serif; }
       body { 
            /* Red to white gradient background */
            background: linear-gradient(to bottom right, #ff4d4d, #ffffff);
            color: #333; 
            min-height: 100vh;
        }

        /*.dashboard-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }*/

        .profile-card {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .profile-card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h3 { margin-bottom: 5px; }
        .profile-info p { color: #555; margin-bottom: 10px; }

        .profile-info button {
            padding: 7px 15px;
            background: #4f46e5;
            border: none;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
            gap: 20px;
        }

        .dash-box {
            background: #f0f4ff;
            text-align: center;
            padding: 25px 15px;
            border-radius: 12px;
            transition: 0.3s;
            text-decoration: none;
            color: #333;
        }

        .dash-box:hover {
            background: #4f46e5;
            color: #fff;
        }

        .dash-box i {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .dash-box h3 {
            margin-bottom: 5px;
            font-size: 18px;
        }

        .dash-box p { font-size: 14px; color: inherit; }
    </style>
</head>
<body>

<div class="dashboard-container">

    <!-- Seller Profile -->
    <div class="profile-card">
        <img src="https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?semt=ais_hybrid&w=740&q=80" alt="Profile">
        <div class="profile-info">
            <h3><?php echo h($seller['name']); ?></h3>
            <p>Email: <?php echo h($seller['email']); ?></p>
            <p>Contact: <?php echo h($seller['contact']); ?></p>
            <p>Joined: <?php echo date("F j, Y", strtotime($seller['created_at'])); ?></p>
        </div>
    </div>

    <!-- Dashboard Boxes -->
    <div class="dashboard-grid">
        <a href="add_product.php" class="dash-box">
            <i class="fa fa-plus-circle"></i>
            <h3>Add Product</h3>
            <p>নতুন কৃষি আইটেম আপলোড</p>
        </a>
        <a href="manage_products.php" class="dash-box">
            <i class="fa fa-edit"></i>
            <h3>Manage Products</h3>
            <p>পণ্য অনুসন্ধান, আপডেট বা অপসারণ</p>
        </a>
        <a href="order_information.php" class="dash-box">
            <i class="fa fa-truck"></i>
            <h3>Order Information</h3>
            <p>দেখুন এবং অর্ডার প্রদান</p>
        </a>
        <a href="notifications.php" class="dash-box">
            <i class="fa fa-bell"></i>
            <h3>Notifications</h3>
            <p>নতুন সতর্কতা এবং বার্তা দেখুন</p>
        </a>
    </div>

</div>

</body>
</html>
