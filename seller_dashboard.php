<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$uid = intval($_SESSION['user_id']); 
$seller = null;
$sql = "SELECT name, email, contact, created_at FROM sellers WHERE user_id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $uid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) === 1) {
    $seller = mysqli_fetch_assoc($result);
} 
else {
    header("Location: seller_dashboard.php");
    exit();
}
mysqli_stmt_close($stmt);
function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

$seller_name    = $seller['name'] ?? 'Seller';
$seller_email   = $seller['email'] ?? 'Not Provided';
$seller_contact = $seller['contact'] ?? 'Not Provided';
$seller_joined  = !empty($seller['created_at']) ? date("F j, Y", strtotime($seller['created_at'])) : 'Not Recorded';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard | AgroTradeHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
       body { 
    margin:0; 
    padding:0; 
    font-family:'Poppins',sans-serif; 
    background: url('https://t3.ftcdn.net/jpg/15/20/56/68/360_F_1520566864_eotnOsoKbNWuQlKPXPRzDqKz0II1jARE.jpg') no-repeat center center/cover; 
    background-size: 150%;   
}

.page{ 
    max-width:1000px; 
    margin:40px auto; 
    padding:18px; 
    background: rgba(255, 255, 255, 0.25);
    border-radius:15px;
    box-shadow:0 4px 20px rgba(0,0,0,0.15);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.35);
    margin-left: 150px;  
}


.header{ 
    display:flex; 
    justify-content: center; 
    align-items:center; 
    margin-bottom:30px; 
}

.profile-card{
    width: 260px;                 
    min-height: 100vh;             
    position: fixed;               
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.25);
    border-radius: 0 18px 18px 0;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 4px 0 12px rgba(0,0,0,0.1);
    padding: 25px 20px;
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
    color:#444;
}

.logout-btn{
    margin: 30px;
    padding:15px 20px; 
    background: rgb(0, 63, 13); 
    color:white; 
    border:none;
    border-radius:8px;  
    font-weight:700;
    transition:0.3s;
}
.logout-btn:hover{
    background: rgb(3, 19, 0);
    color: white;
}

.dashboard-grid{
     display: grid;
    grid-template-columns: repeat(2, 1fr); 
    gap: 22px;
    margin-top: 20px;
    justify-content: end;   
}

.dash-box{
    background: rgba(15, 160, 44, 1); 
    padding:14px 18px; 
    border-radius:14px;
    text-align:center; 
    transition:.30s; 
    color:#000; 
    text-decoration:none;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    gap: 22px;
}
.dash-box:hover{ 
    background: rgb(0, 63, 13); 
    color: white; 
    transform:translateY(-8px); 
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

.dash-box i{ 
    font-size:32px; 
    margin-bottom:12px; 
}

.dash-box h3{ 
    margin:0 0 8px; 
    font-size:17px; 
    font-weight:600;
}

.dash-box p{ 
    margin:0; 
    font-size:13px; 
    opacity:0.85;
}

    </style>
</head>

<body>
<div class="page">

    <div class="header">
        <div class="profile-card">
            <img src="https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg">
            <div class="profile-info">
                <h3><?= h($seller_name) ?></h3>
                <p>Email: <?= h($seller_email) ?></p>
                <p>Contact: <?= h($seller_contact) ?></p>
                <p style="font-size:12px;color:#666;">Joined: <?= h($seller_joined) ?></p>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <a href="add_product.php" class="dash-box">
            <i class="fa fa-plus-circle"></i>
            <h3>Add Product</h3>
            <p>নতুন কৃষি আইটেম যোগ করুন</p>
        </a>

        <a href="manage_products.php" class="dash-box">
            <i class="fa fa-edit"></i>
            <h3>Manage Products</h3>
            <p>পণ্য পরিচালনা করুন</p>
        </a>

        <a href="order_information.php" class="dash-box">
            <i class="fa fa-truck"></i>
            <h3>Order Information</h3>
            <p>অর্ডার ইতিহাস দেখুন</p>
        </a>

        <a href="notifications.php" class="dash-box">
            <i class="fa fa-bell"></i>
            <h3>Notifications</h3>
            <p>নোটিফিকেশন পড়ুন</p>
        </a>
    </div>

    <div>
         <button class="logout-btn" onclick="window.location.href='logout.php'"> Logout </button>
</dive>

</div>
</body>
</html>
