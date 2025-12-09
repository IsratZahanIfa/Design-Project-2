<?php
session_start();
include 'db.php';


if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}


// -------------------------------------
// APPROVE ORDER
// -------------------------------------
if (isset($_GET['approve'])) {
    $order_id = intval($_GET['approve']);


    $stmt = $conn->prepare("UPDATE orders SET status='approved' WHERE id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();


    header("Location: notifications.php");
    exit;
}


// -------------------------------------
// DELETE ORDER
// -------------------------------------
if (isset($_GET['delete'])) {
    $order_id = intval($_GET['delete']);


    $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();


    header("Location: notifications.php");
    exit;
}


$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");


?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Notifications</title>
    <style>
        body { font-family: Arial; margin:0; padding:0; background: #000000ff; }
        .container { width: 90%; margin: 50px auto; background: #c59b9bff; padding: 30px;
        border-radius: 10px; box-shadow:0 0 10px rgba(0,0,0,0.2);}
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border:1px solid #ccc; padding: 12px; text-align: center; }
        th { background: #003f0d; color: #fff; }
        tr:hover { background: #f1f8f1; }
        a.button { padding: 6px 12px; border-radius:5px; color: #fff; text-decoration:none; }
        .approve { background: green; }
        .delete { background: red; }
        .back { margin-top: 20px; display: inline-block; background: black; }
    </style>
</head>
<body>


<div class="container">
    <h2>Order Notifications</h2>


    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Seller</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Store</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>


            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['seller_id'] ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= htmlspecialchars($row['store_name']) ?></td>
                    <td><?= $row['status'] ?></td>


                    <td>
                        <?php if($row['status'] == 'pending'): ?>
                            <a class="button approve" href="notifications.php?approve=<?= $row['id'] ?>">Approve</a>
                            <a class="button delete" href="notifications.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        <?php else: ?>
                            Approved
                        <?php endif; ?>
                    </td>


                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>


    <a href="admin_dashboard.php" class="button back">Back to Dashboard</a>
</div>


</body>
</html>


