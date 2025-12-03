<?php
session_start();
include 'db.php';


$user_id = $_SESSION['user_id'] ?? 0;


if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>alert('Your cart is empty!'); window.location.href='cart.php';</script>";
    exit;
}

if (isset($_POST['confirm_order'])) {

    foreach ($_SESSION['cart'] as $item) {

        $seller_id    = $item['seller_id'];
        $product_id   = $item['product_id'];
        $product_name = $item['product_name'];
        $price        = $item['price'];
        $quantity     = $item['quantity'];
        $store_name   = $item['store_name'];
        $location     = $item['location'] ?? "Not Provided";
        $status       = "Pending";
        $order_date   = date("Y-m-d H:i:s");


        $sql = "INSERT INTO orders 
                (user_id, seller_id, product_id, product_name, price, quantity, store_name, location, order_date)
                VALUES 
                ('$user_id', '$seller_id', '$product_id', '$product_name', '$price', '$quantity', '$store_name', '$location', '$order_date')";

        mysqli_query($conn, $sql);
    }


    unset($_SESSION['cart']);

    echo "<script>alert('Order Confirmed Successfully!'); window.location.href='customer_dashboard.php';</script>";
    exit;
}

$query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 20px; }
        table { width: 90%; margin: auto; border-collapse: collapse; }
        table, th, td { border:1px solid #777; }
        th, td { padding: 10px; }
        th { background: #f2f2f2; }
        button {
            margin-top:20px; 
            padding:10px 20px;
            background: green; 
            color:#fff; 
            border:none;
            border-radius:5px; 
            cursor:pointer;
        }
    </style>
</head>
<body>

<h2>Confirm Your Order</h2>

<form method="post">
    <button type="submit" name="confirm_order">Confirm Order</button>
</form>

<hr><br>

<h2>Your Order History</h2>

<?php if (mysqli_num_rows($result) > 0): ?>

<table>
    <tr>
        <th>Product</th>
        <th>Store</th>
        <th>Price (৳)</th>
        <th>Qty</th>
        <th>location</th>
        <th>status</th>
        <th>Date</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['product_name'] ?></td>
        <td><?= $row['store_name'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $row['location'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['order_date'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php else: ?>
    <p>No orders found.</p>
<?php endif; ?>

</body>
</html>
