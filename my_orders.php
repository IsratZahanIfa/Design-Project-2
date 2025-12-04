<?php
session_start();
include 'db.php';

// Get logged-in customer ID
$user_id = $_SESSION['user_id'] ?? 0;
if ($user_id == 0) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit;
}

// Confirm order submission
if (!empty($_SESSION['cart']) && isset($_POST['confirm_order'])) {

    $order_date     = date("Y-m-d H:i:s");
    
    foreach ($_SESSION['cart'] as $item) {
        $user_id      = $_SESSION['user_id'];
        $product_name = $item['product_name'] ?? "Unknown Product";
        $price        = $item['price'] ?? 0;
        $quantity     = $item['quantity'] ?? 1;
        $store_name   = $item['store_name'] ?? "Unknown Store";
        $seller_id    = $item['seller_id'] ?? 0;

        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_name, price, quantity, store_name, order_date)
    VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "isdiss",
            $user_id,
            $product_name,
            $price,
            $quantity,
            $store_name,
            $order_date
        );


        $stmt->execute();
    }

    // Clear cart
    unset($_SESSION['cart']);

    echo "<script>alert('Order Confirmed Successfully!'); window.location.href='order_confirmation.php';</script>";
    exit;
}

// Fetch previous orders for this customer
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
   
    <button type="button"onclick="window.location.href='customer_dashboard.php';">Back to Dashboard</button>

    <title>Order Confirmation</title>
    <style>
         body {
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: url('https://storage.googleapis.com/48877118-7272-4a4d-b302-0465d8aa4548/8f263d79-144f-48d3-830f-185071cccc54/ad5d1ab1-f95b-46ae-a186-5d877f2e6719.jpg')
                    no-repeat center/cover; 
        background-attachment: fixed;
    }
      .container {
        width: 80%;
        max-width: 850px;
        margin: 80px auto;
        background: rgba(255, 182, 192, 0.28);
        padding: 35px 60px;
        border-radius: 8px;
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        box-shadow: 0 0 18px rgba(255, 182, 192, 0.28);
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
    text-align: center;
    margin-bottom: 25px;
    color: rgb(0, 63, 13);
    font-size: 22px;
    font-weight: 700;
    }

    p {
        text-align: left;
        font-size: 15px;
        color: #333;
    }

         table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    th {
        background: #003f0d;
        color: white;
        font-weight: 600;
        padding: 12px;
        font-size: 14px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }

        tr:hover {
        background: #f1f8f1;
    }

        .no-order {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

                <div class="container">
                <h2>My Orders</h2>
                <?php if(!empty($orders)): ?>
                <table border="1" cellpadding="6" style="width:100%; border-collapse:collapse; margin-top:15px;">
                <tr>
                    <th>Product</th>
                    <th>Store</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Date</th>
                </tr>
                <?php foreach($orders as $o): ?>
                <tr>
                <td><?= htmlspecialchars($o['product_name']) ?></td>
                <td><?= htmlspecialchars($o['store_name']) ?></td>
                <td><?= $o['price'] ?></td>
                <td><?= $o['quantity'] ?></td>
                <td><?= $o['order_date'] ?></td>
                </tr>
                <?php endforeach; ?>
                </table>
                <?php else: ?>
                <p>No previous orders found.</p><?php endif; ?>


</body>
</html>
