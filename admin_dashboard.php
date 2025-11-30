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
            mysqli_query($conn,
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
    SELECT * FROM users u
    WHERE u.role='seller' AND u.id NOT IN (SELECT user_id FROM sellers)
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
    font-size: 14px;            
}

h1 { 
    text-align: center; 
    color: white; 
    font-size: 18px; 
}

table { 
    border-collapse: collapse; 
    width: 80%; 
    margin: 20px auto; 
    color: white;                 
}

th, td { 
    border: 1px solid #444; 
    padding: 8px;                
    text-align: left; 
    font-size: 14px;              
}

th { 
    background: #1a1a1a;         
    color: white; 
}

a.approve { 
    color: #00ff00;              
    text-decoration: none; 
    font-size: 14px;
    font-weight: bold;
}

a.delete { 
    color: #ff4d4d;              
    text-decoration: none; 
    font-size: 14px;
    font-weight: bold;
}

.logout-container { 
    text-align: center; 
    margin: 20px; 
}

.logout { 
    text-decoration: none; 
    color: white; 
    background: #111; 
    padding: 8px 15px; 
    border-radius: 5px; 
    font-size: 14px;
    font-weight: bold;
}

.logout:hover { 
    background: #333; 
}

</style>
</head>
<body>

<h1>Pending Seller Approvals</h1>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($pending_sellers)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td>
                <a class="approve" href="admin_dashboard.php?approve_seller=<?= $row['id'] ?>">✔ Approve</a>
                &nbsp;
                <a class="delete" href="admin_dashboard.php?delete_seller=<?= $row['id'] ?>">🗑 Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<h1>Approved Sellers</h1>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Contact</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($approved_sellers)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
        </tr>
    <?php } ?>
</table>



<div class="logout-container">
    <a href="admin_dashboard.php?logout=1" class="logout">Logout</a>
</div>

</body>
</html>
