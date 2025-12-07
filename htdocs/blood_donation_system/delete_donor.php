<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    echo "Access Denied!";
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM donors WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
    } else {
        echo "Error deleting donor!";
    }
}
?>
