<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$seller_sql = "SELECT email FROM users WHERE id = '$user_id'";
$seller_result = mysqli_query($conn, $seller_sql);
$seller_row = mysqli_fetch_assoc($seller_result);

if (!$seller_row) {
    die("Seller not found.");
}

$seller_email = $seller_row['email'];

$search = "";
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "SELECT * FROM add_products 
        WHERE seller_email = '$seller_email' 
          AND LOWER(name) LIKE LOWER('%$search%')
        ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$count_sql = "SELECT COUNT(*) AS total 
              FROM add_products 
              WHERE seller_email='$seller_email'";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);
$total_products = $count_row['total'];

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
    body {
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: url('https://storage.googleapis.com/48877118-7272-4a4d-b302-0465d8aa4548/8f263d79-144f-48d3-830f-185071cccc54/ad5d1ab1-f95b-46ae-a186-5d877f2e6719.jpg')
                    no-repeat center/cover; 
        background-attachment: fixed;
    }
.container {
        width: 100%;
        margin: 40px auto;
        background: rgba(255, 182, 192, 0.28);
        padding: 35px 60px;
        border-radius: 8px;
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        box-shadow: 0 0 18px rgba(255, 182, 192, 0.28);
        text-align: left;
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
       text-align: center;
    margin-bottom: 25px;
    color: rgb(0, 63, 13);
    font-size: 22px;
    font-weight: 700;
    }

    p {
        text-align: left;
        font-size: 15px;
        color: #333;
    }

   .search-wrapper {
    position: relative;
    width: 260px;
}

.search-wrapper input {
    width: 100%;
    padding: 10px 40px 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: 0.3s ease;
}

    .search-wrapper input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.3);
}

.search-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: #444;
    opacity: 0.7;
    pointer-events: none;
}


.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn-search {
    background: #006400;
    color: white;
}
.btn-search:hover {
    background: #004d00;
}


    .btn-refresh {
        background: #007bff;
        color: white;
    }
    .btn-refresh:hover { background: #0062c7; }

    .back-btn {
        float: right;
        background: black;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
        margin-bottom: 10px;
        font-weight: 600;
    }
    .back-btn:hover {
        background: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    th {
        background: #003f0d;
        color: white;
        font-weight: 600;
        padding: 12px;
        font-size: 14px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }

    tr:hover {
        background: #f1f8f1;
    }

    .update-box {
        margin-top: 25px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .update-box input {
        width: 220px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #bbb;
        font-size: 13px;
    }

  .update-box, .delete-box {
    width: 350px;      
    padding: 15px;     
    border-radius: 8px;
}

    .btn-update:hover { 
        background: rgb(3, 19, 0);
        color: white;
    }

    .btn-delete {
        background: rgb(0, 63, 13);
        color: white;
    }
    .btn-delete:hover { 
         background: rgb(3, 19, 0);
        color: white; 
        }
</style>

</head>
<body>

<div class="container">
    <h2>My Products</h2>
    <p>You have <strong><?php echo $total_products; ?></strong> products added.</p>

    <form method="GET" style="margin-bottom:10px; display:flex; gap:5px; align-items:center;">
    
    <div class="search-wrapper">
        <input type="text" name="search" placeholder="Search product..."
               value="<?php echo htmlspecialchars($search); ?>">
      
    </div>

    <button type="submit" class="search-btn"><i class="search-icon">&#128269;</i></button>

    <button type="button" class="refresh-btn"
        onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>';">
        Refresh
    </button>

</form>



    <button class="back-btn" onclick="window.location.href='seller_dashboard.php';">← Back to Dashboard</button>

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

    <form method="POST" >
        <input type="text" name="product_name" placeholder="Type exact product name" required>
        <input type="number" name="price" placeholder="New Price" step="0.01" min="0">
        <input type="number" name="quantity" placeholder="New Quantity" min="0">
        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete" onclick="return confirm('Are you sure to delete this product?');">Delete</button>
    </form>
</div>

</body>
</html>