<?php
session_start();
include 'db.php';

// Admin page: fetch all products
$search = "";
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "SELECT * FROM add_products 
        WHERE LOWER(name) LIKE LOWER('%$search%')
        ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$count_sql = "SELECT COUNT(*) AS total FROM add_products";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_products = $count_row['total'];

// Delete product
if (isset($_POST['delete'])) {
    $prod_name = trim($_POST['product_name']);
    $delete_sql = "DELETE FROM add_products WHERE name='$prod_name'";
    mysqli_query($conn, $delete_sql);
    header("Location: ".$_SERVER['PHP_SELF']."?search=".urlencode($search));
    exit();
}

// Update price
if (isset($_POST['update'])) {
    $prod_name = trim($_POST['product_select']);
    $price = trim($_POST['price']);
    if ($price !== '') {
        $update_sql = "UPDATE add_products SET price='$price' WHERE name='$prod_name'";
        mysqli_query($conn, $update_sql);
    }
    header("Location: ".$_SERVER['PHP_SELF']."?search=".urlencode($search));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All Products | Admin</title>
<style>
     * { 
       margin:0; 
       padding:0; 
       box-sizing:border-box; 
       font-family: Arial, sans-serif; 
    }

        body { 
            background:#121212; 
            color:#fff; 
            padding:18px; 
        }
        h2 { 
            font-size:22px; 
            margin-bottom:20px; 
                 }
        p { 
            margin-bottom:15px; 
        }

        .search-wrapper {
            margin-bottom: 10px;
        }
        .search-wrapper input {
            width: 200px;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .btn-refresh {
            background: #004d00;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 5px;
        }
        .btn-refresh:hover { background: #003300; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: rgb(0, 63, 13);
            color: white;
        }


        .bttn-delete {
            background: #cc0000;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .bttn-delete:hover { background: #990000; }

        .update-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        .update-form input, .update-form select {
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
</style>
</head>
<body>

<div class="container">
<h2>All Products</h2>
<p>Total Products: <strong><?php echo $total_products; ?></strong></p>

<div class="search-wrapper">
    <form method="GET">
        <input type="text" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn-refresh">Search</button>
        <button type="button" class="btn-refresh" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>';">Refresh</button>
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
            <td>
                <!-- Delete button -->
            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                <button type="submit" name="delete" class="bttn-delete">&#128465; </button>
            </form>

            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="8">No products found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<!-- Update Price Form -->
    <form method="POST" style="display:flex; gap:10px; align-items:center; flex-wrap: wrap; background:#111; padding:15px 20px; border-radius:8px;">
        <select name="product_select" required style="padding:8px 12px; border-radius:6px; border:1px solid #444; background:#222; color:white; min-width:150px;">
            <?php
            $result2 = mysqli_query($conn, "SELECT name FROM add_products ORDER BY name ASC");
            while($r = mysqli_fetch_assoc($result2)) {
                echo "<option value='".htmlspecialchars($r['name'])."'>".htmlspecialchars($r['name'])."</option>";
            }
            ?>
        </select>
        <input type="number" name="price" placeholder="New Price" step="0.01" min="0" required style="padding:8px 12px; border-radius:6px; border:1px solid #444; background:#222; color:white; min-width:120px;">
        <button type="submit" name="update" style="background:#004d00; color:white; border:none; padding:8px 16px; border-radius:6px; cursor:pointer;">Update Price</button>
    </form>




</div>
</body>
</html>
