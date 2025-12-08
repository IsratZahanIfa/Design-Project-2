<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: admin.php");
    exit;
}

$isAdmin = ($_SESSION['id'] == 1);


$confirmed_items = $_SESSION['cart'];
$user_id = $_SESSION['user_id'];

$conn->begin_transaction();

foreach ($confirmed_items as $item) {
    $seller_id = $item['seller_id'];
    $product_id = $item['product_id'];
    $product_name = $item['product_name'];
    $price = $item['price'];
    $quantity = $item['quantity'];
    $store_name = $item['store_name'];
    $location = $item['location'];
    $status = "confirmed";
    $order_date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO orders (seller_id, product_id, product_name, price, quantity, store_name, location, status, order_date)
            VALUES ('$seller_id','$product_id','$product_name','$price','$quantity','$store_name','$location','$status','$order_date')";
    $conn->query($sql);
}

$conn->commit();
$_SESSION['cart'] = [];


$message = "Your order has been placed successfully!";
mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$message')");


foreach ($confirmed_items as $ci) {
    $seller_id = $ci['seller_id'];
    $seller_msg = "New order received: {$ci['product_name']} ({$ci['quantity']} pcs).";
    mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ('$seller_id', '$seller_msg')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart Order Confirmation</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; display:flex; justify-content:center; align-items:center; height:100vh; margin:0;}
        .order-box {background:rgba(255,255,255,0.9); padding:25px; width:380px; border-radius:12px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.2);}
        button {background:#007bff; color:#fff; border:none; padding:12px 20px; border-radius:6px; cursor:pointer; font-size:16px; transition:0.3s;}
        button:hover {background:#0056b3;}
        h2 {margin-bottom:15px;}
        p {font-size:14px; margin-bottom:20px;}
    </style>
</head>
<body>
<div class="order-box">
    <h2>Order Placed!</h2>
    <p>Your cart order has been successfully placed.</p>
    <a href="customer_dashboard.php"><button>Back to Dashboard</button></a>
</div>
</body>
</html>
