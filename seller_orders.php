<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php"); exit();
}

$seller_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT o.order_id, o.product_name, o.quantity, o.price, s.store_name 
                        FROM orders o 
                        JOIN stores s ON o.store_id = s.store_id 
                        WHERE o.seller_id = ? AND o.status='Pending'");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$orders = $stmt->get_result();
$stmt->close();
?>

<h1>Pending Orders</h1>
<?php while ($row = $orders->fetch_assoc()): ?>
    <p>
        Product: <?= htmlspecialchars($row['product_name']) ?> |
        Quantity: <?= $row['quantity'] ?> |
        Price: <?= $row['price'] ?> |
        Store: <?= htmlspecialchars($row['store_name']) ?> |
        <a href="approve_order.php?order_id=<?= $row['order_id'] ?>">Approve</a>
    </p>
<?php endwhile; ?>
