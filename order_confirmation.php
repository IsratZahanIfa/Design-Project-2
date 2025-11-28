<?php
session_start();
include 'db.php';

// Enable error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$confirmed_items = [];

if (isset($_POST['confirm_order']) && !empty($_SESSION['cart'])) {
    $conn->begin_transaction();

    try {
        foreach ($_SESSION['cart'] as $item) {
            $product_id   = intval($item['product_id']);
            $product_name = trim($item['product_name']);
            $price        = floatval($item['price']);
            $quantity     = intval($item['quantity']);
            $store_name   = trim($item['store_name']);
            $seller_id    = intval($item['seller_id']);
            $order_date   = date("Y-m-d H:i:s");

            if ($product_id <= 0 || $product_name === '' || $quantity <= 0 || $store_name === '' || $seller_id <= 0) {
                continue;
            }

            // Correct bind_param types:
            // i = integer, s = string, d = double (float)
            $stmt = $conn->prepare("INSERT INTO stores
                (product_id, product_name, price, quantity, store_name, seller_id, order_date, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')");
           $stmt->bind_param("isdiiss", $product_id, $product_name, $price, $quantity, $store_name, $seller_id, $order_date);


            $stmt->execute();

            $confirmed_items[] = [
                'product_name' => $product_name,
                'store_name'   => $store_name,
                'price'        => $price,
                'quantity'     => $quantity,
                'subtotal'     => $price * $quantity
            ];

            $stmt->close();
        }

        $conn->commit();
        $_SESSION['cart'] = []; // clear cart after confirmation

    } catch (Exception $e) {
        $conn->rollback();
        die("Error saving order: " . $e->getMessage());
    }
} else {
    header("Location: cart.php");
    exit;
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
<h1>✅ Order Confirmed!</h1>
<a href="products.php">← Continue Shopping</a>

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
            <?php $grand_total = 0; ?>
            <?php foreach ($confirmed_items as $item): ?>
                <?php $grand_total += $item['subtotal']; ?>
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
<?php else: ?>
    <p>No items were confirmed.</p>
<?php endif; ?>
</div>
</body>
</html>
