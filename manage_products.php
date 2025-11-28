<?php
session_start();
include 'db.php';

// Only sellers can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

// Get logged-in seller's email
$user_id = $_SESSION['user_id'];
$seller_sql = "SELECT email FROM users WHERE id = '$user_id'";
$seller_result = mysqli_query($conn, $seller_sql);
$seller_row = mysqli_fetch_assoc($seller_result);

if (!$seller_row) {
    die("Seller not found.");
}

$seller_email = $seller_row['email'];

// Handle search
$search = "";
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// Fetch products added by this seller only (case-insensitive)
$sql = "SELECT * FROM add_products 
        WHERE seller_email = '$seller_email' 
          AND LOWER(name) LIKE LOWER('%$search%')
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

// Count total products
$count_sql = "SELECT COUNT(*) AS total 
              FROM add_products 
              WHERE seller_email='$seller_email'";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_products = $count_row['total'];

// Handle Update
if (isset($_POST['update'])) {
    $prod_name = trim($_POST['product_name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    $update_fields = [];
    if ($price !== '') $update_fields[] = "price='$price'";
    if ($quantity !== '') $update_fields[] = "quantity='$quantity'";

    if (!empty($update_fields)) {
        $update_sql = "UPDATE add_products SET ".implode(',', $update_fields)." 
                       WHERE name='$prod_name' AND seller_email='$seller_email'";
        mysqli_query($conn, $update_sql);
    }

    header("Location: ".$_SERVER['PHP_SELF']."?search=".urlencode($search));
    exit();
}

// Handle Delete
if (isset($_POST['delete'])) {
    $prod_name = trim($_POST['product_name']);
    $delete_sql = "DELETE FROM add_products 
                   WHERE name='$prod_name' AND seller_email='$seller_email'";
    mysqli_query($conn, $delete_sql);
    header("Location: ".$_SERVER['PHP_SELF']."?search=".urlencode($search));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage My Products | AgroTradeHub</title>
<link rel="stylesheet" href="style.css">
<style>
.container { max-width: 1000px; margin: 20px auto; }
button, input { padding: 8px 12px; border-radius: 5px; border: 1px solid #ccc; }
button { cursor: pointer; }
.back-btn { background: #000; color: #fff; border: none; margin-top: 10px; }
.back-btn:hover { background: #333; }
.refresh-btn { background: #007bff; color: #fff; border: none; }
.refresh-btn:hover { background: #0056b3; }
</style>
</head>
<body>

<div class="container">
    <h2>My Products</h2>
    <p>You have <strong><?php echo $total_products; ?></strong> products added.</p>

    <!-- Search Form -->
    <form method="GET" style="margin-bottom:10px; display:flex; gap:5px;">
        <input type="text" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        <button type="button" class="refresh-btn" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>';">Refresh</button>
    </form>

    <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='seller_dashboard.php';">← Back</button>

    <!-- Products Table -->
    <table border="1" cellpadding="10" style="width:100%; border-collapse:collapse; margin-top:15px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price (৳)</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Store</th>
                <th>Location</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)):
                $status = ($row['quantity']==0) ? 'Out of Stock' : (($row['quantity']<=10) ? 'Low Stock' : 'In Stock');
                $color = ($row['quantity']==0) ? 'red' : (($row['quantity']<=10) ? 'orange' : 'green');
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td style="color:<?php echo $color; ?>"><?php echo $status; ?></td>
                    <td><?php echo htmlspecialchars($row['store_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No products found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Update/Delete Form -->
    <form method="POST" style="margin-top:15px; display:flex; gap:10px; align-items:center;">
        <input type="text" name="product_name" placeholder="Type exact product name" required>
        <input type="number" name="price" placeholder="New Price (optional)" step="0.01" min="0">
        <input type="number" name="quantity" placeholder="New Quantity (optional)" min="0">
        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete" onclick="return confirm('Are you sure to delete this product?');">Delete</button>
    </form>
</div>

</body>
</html>
