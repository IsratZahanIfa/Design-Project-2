<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];


$search = "";
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}


$sql = "SELECT * FROM add_products 
        WHERE seller_id = $seller_id
        AND LOWER(name) LIKE LOWER('%$search%')
        ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$total_products = ($result) ? mysqli_num_rows($result) : 0;

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM add_products WHERE id=$id AND seller_id=$seller_id");
    header("Location: manage_products.php");
    exit;
}

if (isset($_POST['update'])) {
    $pid = intval($_POST['product_select']);
    $new_price = floatval($_POST['price']);

    mysqli_query($conn, "UPDATE add_products 
                         SET price=$new_price
                         WHERE id=$pid AND seller_id=$seller_id");

    echo "<script>alert('Product price updated!'); window.location.href='manage_products.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Products | Seller</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: url('https://storage.googleapis.com/48877118-7272-4a4d-b302-0465d8aa4548/8f263d79-144f-48d3-830f-185071cccc54/ad5d1ab1-f95b-46ae-a186-5d877f2e6719.jpg')
                    no-repeat center center fixed;
        background-size: cover;
    }

    .container {
        width: 85%;
        margin: 40px auto;
        background: rgba(255, 182, 192, 0.28);
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        backdrop-filter: blur(10px);
    }

    h2 {
        margin-top: 0;
        color: #000000ff;
        font-size: 30px;
        text-align: center;
    }

    p {
        text-align: center;
        font-weight: 600;
        font-size: 20px;
    }

    .search-wrapper {
        text-align: left;
        margin-bottom: 20px;
    }

    .search-wrapper input {
        padding: 8px 15px;
        width: 250px;
        border-radius: 8px;
        border: 1px solid #d6d1d1ff;
    }

    .btn-refresh {
        padding: 8px 15px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        background: #010101ff;
        color: white;
        margin-left: 2px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    th, td {
        padding: 12px;
        text-align: center;
        font-size: 15px;
        border-bottom: 1px solid #ffffffff;
    }

    th {
        background: black;
        font-weight: bold;
        color: White;
    }

    .bttn-delete {
        background: red;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
    }

    .bttn-delete:hover {
        background: darkred;
    }

    .update-box select,
    .update-box input {
        margin-top: 35px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #000000ff;
        background: #090909ff;
        color: white;
        width: 200px;
    }

    .update-btn {
        background: black;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
    }

    .update-btn:hover {
        background: #333;
    }

    .back-btn {
        display: inline-block;
        background: #000; 
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 15px;
        margin-bottom: 18px;
        transition: 0.3s ease;
        font-weight: bold;
    }

    .back-btn:hover {
        background: #333;
        transform: translateX(-3px);
    }
</style>
</head>
<body>
<div class="container">

<a href="seller_dashboard.php" class="back-btn">Back to Dashboard</a>

<h2>All Products</h2>
<p>Total Products: <strong><?php echo $total_products; ?></strong></p>

<div class="search-wrapper">
    <form method="GET">
        <input type="text" name="search" placeholder="Search product..."
               value="<?php echo htmlspecialchars($search); ?>">

        <button type="submit" class="btn-refresh">Search</button>

        <button type="button" class="btn-refresh"
                onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>';">
            Refresh
        </button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Price (৳)</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Store</th>
            <th>Location</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>

            <?php
                $status = ($row['quantity']==0) ? 'Out of Stock' :
                          (($row['quantity']<=10) ? 'Low Stock' : 'In Stock');
                $color = ($row['quantity']==0) ? 'red' :
                         (($row['quantity']<=10) ? 'orange' : 'green');
            ?>
            <td style="color:<?php echo $color; ?>; font-weight:bold;">
                <?php echo $status; ?>
            </td>

            <td><?php echo htmlspecialchars($row['store_name']); ?></td>
            <td><?php echo htmlspecialchars($row['location']); ?></td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>

            <td>
                <a href="?delete=<?php echo $row['id']; ?>" class="bttn-delete" 
                   onclick="return confirm('Are you sure you want to delete this product?');">
                   &#128465;
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="8">No products found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="update-box">
    <form method="POST">
        <select name="product_select" required>
            <?php
            $result2 = mysqli_query($conn, "SELECT id, name FROM add_products WHERE seller_id=$seller_id ORDER BY name ASC");
            while ($r = mysqli_fetch_assoc($result2)) {
                echo "<option value='".$r['id']."'>".htmlspecialchars($r['name'])."</option>";
            }
            ?>
        </select>

        <input type="number" name="price" placeholder="New Price" step="0.01" min="0" required>

        <button type="submit" name="update" class="update-btn">Update Price</button>
    </form>
</div>

</div>
</body>
</html>
