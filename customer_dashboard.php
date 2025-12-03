<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    header("Location: login.php");
    exit();
}

$uid = intval($_SESSION['user_id']);

$sql = "SELECT name, email, contact, created_at FROM users WHERE id = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Database error (prepare failed): " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $uid);

if (!mysqli_stmt_execute($stmt)) {
    die("Database error (execute failed): " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);

$customer = ($result && mysqli_num_rows($result) === 1) ? mysqli_fetch_assoc($result) : null;

mysqli_stmt_close($stmt);

function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

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

        
.page{ 
    max-width: 1000px; 
    margin: 40px auto; 
    padding: 18px; 
    background: rgba(7, 1, 1, 0.25);
    border-radius: 15px;
    box-shadow:0 4px 20px rgba(0,0,0,0.15);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(4px);
    border: 2px solid rgba(255, 255, 255, 0.35);
    margin-left: 150px;  
}


.header{ 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    margin-bottom: 30px; 
    border-radius: 15px;
}

.profile-card{
    width: 200px;                 
    min-height: 30vh;             
    position: fixed;               
    top: 70px;
    left: 50px;
    background: rgba(203, 197, 197, 0.25);
    border-radius: 5px 18px 18px 7px;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(8px);
    box-shadow: 4px 0 12px rgba(0, 0, 0, 0.82);
    padding: 25px 20px;
    border-radius: 16px;
    display: flex;
    flex-direction: column;        
    align-items: center;
    gap: 15px;
}

.profile-card img{
    width:90px; 
    height:90px; 
    border-radius:50%; 
    object-fit:cover; 
    border:3px solid #4f46e5;
}

.profile-info{
    text-align:center;
}

.profile-info h3{
    margin:0;
    font-size:20px;
}

.profile-info p{
    margin:5px 0;
    color: #070707ff;
}

.dashboard-grid{
    display: grid;
    grid-template-columns: repeat(2, 300px); 
    gap: 22px;
    margin-top: 40px;
    justify-content: end;     
    margin-left: 80px;  
}

.dash-box{
    background: rgb(0, 63, 19); 
    padding: 25px 20px; 
    border-radius: 14px;
    text-align: center; 
    transition:.30s; 
    color: #000; 
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    width: 250px;  
    height: 150px; 
    right: 10px;
}

.dash-box:hover{ 
    background: rgb(3, 19, 0);
    color: white; 
    transform:translateY(-8px); 
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

.dash-box i{ 
    font-size:32px; 
    margin-bottom:12px; 
}

.dash-box h3{ 
    margin: 0 0 8px; 
    font-size: 17px; 
    font-weight:600;
}

.dash-box p{ 
    margin: 0; 
    font-size: 13px; 
    opacity: 0.85;
}

.logout-btn{
    margin: 30px;
    padding:15px 20px; 
    background: rgb(0, 63, 13); 
    color: white; 
    border:none;
    border-radius:8px;  
    font-weight:700;
    transition:0.3s;
}
.logout-btn:hover{
    background: rgb(3, 19, 0);
    color: white;
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
