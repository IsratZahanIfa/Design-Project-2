<?php
session_start();
include 'db.php';  

if (isset($_POST['confirm_order'])) {
    $seller_id    = $_SESSION['seller_id'];
    $product_id   = $_SESSION['product_id'];
    $product_name = $_SESSION['product_name'];
    $price        = $_SESSION['price'];
    $quantity     = $_SESSION['quantity'];
    $store_name   = $_SESSION['store_name'];
    $location     = $_SESSION['location'];
    $status = "Pending";
    $order_date = date("Y-m-d H:i:s");


    $sql = "INSERT INTO orders (seller_id, product_id, product_name, price, quantity, store_name, location, status, order_date)
            VALUES ('$seller_id', '$product_id', '$product_name', '$price', '$quantity', '$store_name', '$location', '$status', '$order_date')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Order Confirmed Successfully!'); window.location.href='customer_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Order</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f4f4f4;
            margin:0;
            padding:0;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .order-box {
            background:rgba(255,255,255,0.7);
            padding:25px;
            width:380px;
            border-radius:12px;
            backdrop-filter:blur(10px);
            box-shadow:0 4px 20px rgba(0,0,0,0.2);
            text-align:center;
        }

        button {
            background:#007bff;
            color:#fff;
            border:none;
            padding:12px 20px;
            border-radius:6px;
            cursor:pointer;
            font-size:16px;
            transition:0.3s;
        }

        button:hover {
            background:#0056b3;
        }
    </style>
</head>

<body>

<div class="order-box">
    <h2>Confirm Your Order</h2>
    <p>Click the button below to insert order data into the order table.</p>

    <form method="post" action="order_confirmation.php">
        <button type="submit" name="confirm_order">Confirm Order</button>
    </form>
</div>

</body>
</html>
