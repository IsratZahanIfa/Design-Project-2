<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['confirm_order']) || empty($_SESSION['cart'])) {
    header("Location: cart.php?message=" . urlencode("No items in cart."));
    exit();
}

$confirmed_items = [];
$conn->begin_transaction();

try {
    foreach ($_SESSION['cart'] as $item) {
        $product_id = intval($item['product_id']);
        $product_name = $item['product_name'];
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $store_name = $item['store_name'] ?? '';
        $seller_id = intval($item['seller_id'] ?? 0);

        if ($product_id <= 0 || $product_name === '' || $quantity <= 0 || $store_name === '' || $seller_id <= 0) {
            continue;
        }

        // Insert into orders table (or stores if you insist)
        $order_date = date("Y-m-d H:i:s");
        $insert = $conn->prepare("INSERT INTO orders
            (product_id, product_name, price, quantity, store_name, seller_id, status, order_date)
            VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?)");
        $insert->bind_param("isdisis", $product_id, $product_name, $price, $quantity, $store_name, $seller_id, $order_date);
        if ($insert->execute()) {
            $confirmed_items[] = [
                'product_name' => $product_name,
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $price * $quantity,
                'store_name' => $store_name
            ];
        }
        $insert->close();
    }

    $conn->commit();
    $_SESSION['cart'] = [];

} catch (Exception $e) {
    $conn->rollback();
    die("Error confirming order: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Confirmation</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="cart-wrap">
    <h1>✅ Your Order Has Been Placed!</h1>
    <?php if (!empty($confirmed_items)): ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Store</th>
                    <th>Price (৳)</th>
                    <th>Quantity</th>
                    <th>Subtotal (৳)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grand_total = 0;
                foreach ($confirmed_items as $item):
                    $grand_total += $item['subtotal'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= htmlspecialchars($item['store_name']) ?></td>
                        <td><?= number_format($item['price'],2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['subtotal'],2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Total: ৳ <?= number_format($grand_total,2) ?></strong></p>
        <a href="products.php">← Continue Shopping</a>
    <?php else: ?>
        <p>No items were confirmed.</p>
    <?php endif; ?>
</div>
</body>
</html>
