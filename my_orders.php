<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit;
}

// =======================================================
//  PROCESS ORDER CONFIRMATION
// =======================================================

if (!empty($_SESSION['cart']) && isset($_POST['confirm_order'])) {

    $order_date = date("Y-m-d H:i:s");

    foreach ($_SESSION['cart'] as $item) {

        $product_name = $item['product_name'] ?? "Unknown Product";
        $price        = $item['price'] ?? 0;
        $quantity     = $item['quantity'] ?? 1;
        $store_name   = $item['store_name'] ?? "Unknown Store";

        // ---------------------------------------------------
        // 🔥 FETCH seller_id FROM add_products table
        // ---------------------------------------------------
        $findSeller = $conn->prepare("SELECT seller_id FROM add_products WHERE store_name = ? LIMIT 1");
        $findSeller->bind_param("s", $store_name);
        $findSeller->execute();
        $sellerRes = $findSeller->get_result();
        $sellerRow = $sellerRes->fetch_assoc();
        $seller_id = $sellerRow['seller_id'] ?? 0;

        // ---------------------------------------------------
        // 🔥 INSERT ORDER WITH seller_id
        // ---------------------------------------------------
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, seller_id, product_name, price, quantity, store_name, order_date)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iisdiss",
            $user_id,
            $seller_id,
            $product_name,
            $price,
            $quantity,
            $store_name,
            $order_date
        );

        $stmt->execute();
    }

    unset($_SESSION['cart']);

    echo "<script>alert('Order Confirmed Successfully!');</script>";
    echo "<script>window.location.href='order_confirmation.php';</script>";
    exit;
}

// =======================================================
//  FETCH ALL ORDERS OF THIS CUSTOMER
// =======================================================
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://storage.googleapis.com/48877118-7272-4a4d-b302-0465d8aa4548/8f263d79-144f-48d3-830f-185071cccc54/ad5d1ab1-f95b-46ae-a186-5d877f2e6719.jpg')
                        no-repeat center/cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        button {
            margin: 20px;
            padding: 10px 18px;
            background: black;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .container {
            width: 80%;
            max-width: 850px;
            margin: 80px auto;
            background: rgba(255, 182, 192, 0.28);
            padding: 35px 60px;
            border-radius: 8px;
            backdrop-filter: blur(6px);
            box-shadow: 0 0 18px rgba(255, 182, 192, 0.28);
        }

        h2 {
            text-align: center;
            color: rgb(0, 63, 13);
            font-size: 22px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background: #003f0d;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f1f8f1;
        }

        .no-order {
            text-align: center;
            font-size: 18px;
            padding: 25px;
        }
    </style>
</head>

<body>

<button onclick="window.location.href='customer_dashboard.php';">Back to Dashboard</button>

<div class="container">
    <h2>My Orders</h2>

    <?php if (!empty($orders)): ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Store</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Date</th>
            </tr>

            <?php foreach ($orders as $o): ?>
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
        <p class="no-order">No previous orders found.</p>
    <?php endif; ?>
</div>

</body>
</html>
