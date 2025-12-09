<?php
session_start();
include 'db.php';

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product_id   = $_POST['product_id'] ?? null;
    $product_name = $_POST['product_name'] ?? 'Item';
    $price        = floatval($_POST['price'] ?? 0);
    $store_name   = $_POST['store_name'] ?? '';
    $seller_id    = $_POST['seller_id'] ?? 0;

    $foundIndex = null;
    foreach ($_SESSION['cart'] as $idx => $row) {
        if ($product_id !== null && isset($row['product_id']) && $row['product_id'] == $product_id) {
            $foundIndex = $idx;
            break;
        }
    }

    if ($foundIndex !== null) {
        $_SESSION['cart'][$foundIndex]['quantity'] += 1;
    } else {
        $_SESSION['cart'][] = [
            'product_id'   => $product_id,
            'product_name' => $product_name,
            'price'        => $price,
            'quantity'     => 0,
            'store_name'   => $store_name,
            'seller_id'    => $seller_id
        ];
    }

    header("Location: cart.php");
    exit;
}

if (isset($_GET['remove_index'])) {
    $remove_index = intval($_GET['remove_index']);
    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: cart.php");
    exit;
}

if (isset($_POST['update_cart']) && isset($_POST['quantity']) && is_array($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $index => $qty) {
        $i = intval($index);
        $q = intval($qty);
        if ($q < 1) $q = 1;
        if (isset($_SESSION['cart'][$i])) {
            $_SESSION['cart'][$i]['quantity'] = $q;
        }
    }
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart</title>

<style>
#checkoutBox {
    width: 350px;
    background: white;
    padding: 20px;
    border-radius: 10px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0px 4px 20px rgba(0,0,0,0.2);
    display: none;
    z-index: 999;
}
#overlay {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.5);
    display:none;
    z-index: 998;
}
button {
    padding:8px 15px;
}
</style>

</head>
<body>

<div class="cart-wrap">
<h1>🛒 My Shopping Cart</h1>
<a href="categories.php">← Continue Shopping</a>

<?php if (!empty($_SESSION['cart'])): ?>
    <form method="post" action="">
        <table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Store Name</th>
            <th>Price (৳)</th>
            <th>Quantity</th>
            <th>Subtotal (৳)</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php 
            $grand_total = 0;
            $today = date("Y-m-d");
        ?>
        
        <?php foreach ($_SESSION['cart'] as $index => $item): ?>

    <?php
        $product_id = $item['product_id'] ?? null;
        $price      = $item['price'] ?? 0;
        $quantity   = $item['quantity'] ?? 1;
        if ($product_id) {
            $stmt = mysqli_prepare($conn, "SELECT product_name, store_name FROM add_products WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $product_name_db, $store_name_db);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            $product_name = $product_name_db ?? null;
            $store_name   = $store_name_db ?? null;
        } else {
            $product_name = 'Unknown Product';
            $store_name   = 'Unknown Store';
        }

        $subtotal = $price * $quantity;
        $grand_total += $subtotal;
    ?>

    <tr>
        <td><?= htmlspecialchars($product_name) ?></td>
        <td><?= htmlspecialchars($store_name) ?></td>
        <td><?= number_format($price, 2) ?></td>
        <td>
            <input type="number" name="quantity[<?= $index ?>]" value="<?= $quantity ?>" min="1">
        </td>
        <td><?= number_format($subtotal, 2) ?></td>
        <td><?= $today ?></td>
        <td>
            <a href="?remove_index=<?= $index ?>" onclick="return confirm('Remove?')">Remove</a>
        </td>
    </tr>

<?php endforeach; ?>


    </tbody>
</table>

<p>Total: ৳ <?= number_format($grand_total, 2) ?></p>

        <button type="submit" name="update_cart">Update Cart</button>
    </form>
<form method="post" action="">
<table border="1" cellpadding="8">
<thead>
<tr>
    <th>Product Name</th>
    <th>Store Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php 
$grand_total = 0;
foreach ($_SESSION['cart'] as $index => $item):

    $subtotal = $item['price'] * $item['quantity'];
    $grand_total += $subtotal;
?>
<tr>
    <td><?= $item['product_name'] ?></td>
    <td><?= $item['store_name'] ?></td>
    <td><?= number_format($item['price'],2) ?></td>
    <td><input type="number" min="1" name="quantity[<?= $index ?>]" value="<?= $item['quantity'] ?>"></td>
    <td><?= number_format($subtotal,2) ?></td>
    <td><a href="?remove_index=<?= $index ?>">Remove</a></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>

<p><b>Total: ৳ <?= number_format($grand_total,2) ?></b></p>

<button type="submit" name="update_cart">Update Cart</button>
</form>

<button onclick="showCheckout()">Confirm Order</button>

<div>
<button onclick="window.location.href='customer_dashboard.php'">Back</button>
</div>

<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>
</div>

<div id="overlay"></div>

<div id="checkoutBox">
    <h3>Complete Your Order</h3>
    <form method="post" action="my_orders.php">
        <label>Delivery Location:</label><br>
        <input type="text" name="location" required placeholder="Enter your location"><br><br>

        <label>Payment Method:</label><br>
        <select name="payment_method" required>
            <option value="">Select Payment</option>
            <option value="Cash">Cash</option>
            <option value="Bkash">Bkash</option>
            <option value="Nagad">Nagad</option>
        </select><br><br>

        <button type="submit" name="confirm_order" value="1">Place Order</button>
        <button type="button" onclick="hideCheckout()">Cancel</button>
    </form>
</div>

<script>
function showCheckout() {
    document.getElementById("checkoutBox").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}
function hideCheckout() {
    document.getElementById("checkoutBox").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}
</script>

</body>
</html>
