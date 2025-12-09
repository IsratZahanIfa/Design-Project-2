<?php
session_start();
include 'db.php';


if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}


if (isset($_GET['approve_seller'])) {
    $id = intval($_GET['approve_seller']);


    $query = mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='seller'");
    $seller = mysqli_fetch_assoc($query);


    if ($seller) {
        $name    = mysqli_real_escape_string($conn, $seller['name']);
        $email   = mysqli_real_escape_string($conn, $seller['email']);
        $contact = mysqli_real_escape_string($conn, $seller['contact']);


        $check = mysqli_query($conn, "SELECT * FROM sellers WHERE user_id=$id");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query(
                $conn,
                "INSERT INTO sellers (user_id, name, email, contact)
                 VALUES ($id, '$name', '$email', '$contact')"
            );
        }
    }


    header("Location: admin_dashboard.php");
    exit;
}


if (isset($_GET['delete_seller'])) {
    $id = intval($_GET['delete_seller']);


    $check = mysqli_query($conn, "SELECT * FROM sellers WHERE user_id=$id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "DELETE FROM users WHERE id=$id AND role='seller'");
    }


    header("Location: admin_dashboard.php");
    exit;
}




$pending_sellers = mysqli_query($conn, "
    SELECT * FROM users
    WHERE role='seller'
    AND id NOT IN (SELECT user_id FROM sellers)
");


$approved_sellers = mysqli_query($conn, "SELECT * FROM sellers");


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>


<style>
body {
    font-family: Arial, sans-serif;
    background: #040404ff;
    padding: 20px;
    color: white;  
}


h1 {
    text-align: center;
    font-size: 22px;
    margin-top: 20px;
}


.section-title {
    text-align: center;
    font-size: 18px;
    margin-top: 35px;
    color: #00ffcc;
}


table {
    border-collapse: collapse;
    width: 90%;
    margin: 20px auto;
    color: white;
}


th, td {
    border: 1px solid #444;
    padding: 8px;
}


th { background: #1a1a1a; }


.action-btn {
    color: #00eaff;
    font-weight: bold;
    text-decoration: none;
}


.action-btn:hover {
    color: #5efcff;
}


.logout-container {
    text-align: center;
    margin: 25px;
}
.logout {
    color: white;
    background: #111;
    padding: 10px 18px;
    border-radius: 5px;
}
.logout:hover { background: #333; }


.box-links {
    width: 90%;
    margin: auto;
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 12px;
}


.box-links a {
    background: #111;
    padding: 12px;
    color: #00ffe1;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    text-align: center;
}
.box-links a:hover {
    background: #333;
}
</style>
</head>
<body>


<h1>ADMIN DASHBOARD</h1>
<h2 class="section-title">Pending Seller Approvals</h2>


<table>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Contact</th>
    <th>Action</th>
</tr>


<?php while ($row = mysqli_fetch_assoc($pending_sellers)) { ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['contact'] ?></td>
    <td>
        <a class="action-btn" href="admin_dashboard.php?approve_seller=<?= $row['id'] ?>">✔ Approve</a> |
        <a class="action-btn" style="color:#ff4d4d" href="admin_dashboard.php?delete_seller=<?= $row['id'] ?>">🗑 Delete</a>
    </td>
</tr>
<?php } ?>
</table>


<h2 class="section-title">Approved Sellers</h2>


<table>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Contact</th>
</tr>


<?php while ($row = mysqli_fetch_assoc($approved_sellers)) { ?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['contact'] ?></td>
</tr>
<?php } ?>
</table>




<h2 class="section-title">Manage All Tables</h2>


<div class="box-links">


    <a href="manage_users.php">Manage Users</a>
    <a href="manage_add_products.php">Manage Products</a>
    <a href="manage_orders.php">Manage Orders</a>
    <a href="reviews.php">Manage Reviews</a>
    <a href="notifications.php">Manage Notifications</a>




</div>


<div class="logout-container">
    <a href="admin_dashboard.php?logout=1" class="logout">Logout</a>
</div>


</body>
</html>
