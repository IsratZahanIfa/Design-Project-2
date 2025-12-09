<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}


$seller_id = $_SESSION['user_id'];


$query = "
    SELECT
        id AS order_id,
        order_date,
        product_name,
        quantity,
        price
    FROM orders
    WHERE seller_id = ?
    ORDER BY order_date DESC
";


$stmt = $conn->prepare($query);


if (!$stmt) {
    die("SQL ERROR: " . $conn->error);
}


$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();


$orders = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];


$totalOrders  = count($orders);
$totalRevenue = 0;


foreach ($orders as $o) {
    $totalRevenue += floatval($o['price']) * intval($o['quantity']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>
    body {
        font-family: Arial, sans-serif;
        background: #0f0f0f;
        margin: 0;
        padding: 25px;
        color: white;
    }
    .summary {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin: 25px 0;
    }
    .card {
        padding: 20px;
        background: #1a1a1a;
        border-radius: 12px;
        border: 1px solid #333;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #151515;
        border-radius: 12px;
        overflow: hidden;
    }
    th {
        background: #1f1f1f;
        padding: 15px;
        text-align: left;
        color: #ccc;
        font-size: 13px;
    }
    td {
        padding: 15px;
        border-bottom: 1px solid #242424;
    }
    .back-btn {
        margin-top: 25px;
        padding: 12px 20px;
        background: white;
        color: black;
        font-weight: bold;
        border-radius: 8px;
        display: inline-block;
        text-decoration: none;
    }
</style>
</head>


<body>


<h1>Order History</h1>
<p>Only orders belonging to your seller account are shown.</p>


<div class="summary">
    <div class="card"><p>Total Orders</p><h2><?= $totalOrders ?></h2></div>
    <div class="card"><p>Total Revenue</p><h2>$<?= number_format($totalRevenue,2) ?></h2></div>
</div>


<table>
    <thead>
        <tr>
            <th>ORDER ID</th>
            <th>PRODUCT</th>
            <th>QUANTITY</th>
            <th>ORDER DATE</th>
        </tr>
    </thead>


    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td>#<?= $order['order_id'] ?></td>
            <td><?= htmlspecialchars($order['product_name']) ?></td>
            <td><?= $order['quantity'] ?></td>
            <td><?= $order['order_date'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<a href="seller_dashboard.php" class="back-btn">Back</a>


</body>
</html>
