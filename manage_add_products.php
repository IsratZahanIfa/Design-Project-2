<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

$search = "";
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$sql = "SELECT * FROM add_products
        WHERE LOWER(name) LIKE LOWER('%$search%')
        ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$total_products = ($result) ? mysqli_num_rows($result) : 0;

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM add_products WHERE id=$id");
    header("Location: manage_add_products.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin | Manage Products</title>
    <style>
        body {
            background: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 950px;
            margin: auto;
            background: #1e1e1e;
            padding: 25px;
            border-radius: 12px;
        }
        h2 {
            text-align: center;
        }
        .total-products {
            text-align: center;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
            color: cyan;
        }
        .search-box {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .search-box input {
            width: 60%;
            padding: 8px 12px;
            border-radius: 5px;
            border: none;
        }
        .search-box button {
            padding: 8px 15px;
            margin-left: 5px;
            border: none;
            background: orange;
            color: black;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #555;
            padding: 10px;
            text-align: center;
        }
        table th {
            background: #000;
        }
        .btn-delete {
            padding: 5px 10px;
            background: red;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 15px;
            background: cyan;
            color: black;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>
</head>
<body>


<div class="container">


    <a href="admin_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>


    <h2>Manage All Products</h2>
    <div class="total-products">Total Products: <?php echo $total_products; ?></div>


    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>


    <table>
        <tr>
            <th>Name</th>
            <th>Price (৳)</th>
            <th>Seller ID</th>
            <th>Store Name</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['price']; ?> ৳</td>
                    <td><?php echo $row['seller_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['store_name']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="manage_add_products.php?delete=<?php echo $row['id']; ?>"
                           class="btn-delete"
                           onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No products found.</td></tr>
        <?php endif; ?>
    </table>


</div>


</body>
</html>


