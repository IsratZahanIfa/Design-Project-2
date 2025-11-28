<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php"); exit();
}

$order_id = intval($_GET['order_id']);
$seller_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE orders SET status='Confirmed' WHERE order_id=? AND seller_id=?");
$stmt->bind_param("ii", $order_id, $seller_id);
$stmt->execute();
$stmt->close();

header("Location: seller_orders.php?message=" . urlencode("Order approved."));
?>
