<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM sellers WHERE user_id=$id");
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: manage_users.php");
    exit;
}


$users = mysqli_query($conn, "SELECT * FROM users");

$total_users   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users"))['c'];
$total_sellers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE role='seller'"))['c'];
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE role='customer'"))['c'];
?>