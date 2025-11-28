<?php
session_start();
include 'db.php';

// Ensure cart exists
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* -------------------------------
   HANDLE ADD TO CART
--------------------------------- */
if (isset($_POST['add_to_cart'])) {
    $product_id   = $_POST['product_id'] ?? null;
    $product_name = $_POST['product_name'] ?? 'Item';
    $price        = floatval($_POST['price'] ?? 0);
    $store_name   = $_POST['store_name'] ?? '';
    $seller_id    = $_POST['seller_id'] ?? 0;

    // Check if product already exists in cart
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
            'quantity'     => 1,
            'store_name'   => $store_name,
            'seller_id'    => $seller_id
        ];
    }

    header("Location: cart.php");
    exit;
}

/* -------------------------------
   HANDLE REMOVE ITEM
--------------------------------- */
if (isset($_GET['remove_index'])) {
    $remove_index = intval($_GET['remove_index']);
    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: cart.php");
    exit;
}

/* -------------------------------
   HANDLE UPDATE QUANTITIES
--------------------------------- */
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
<title>My Cart | AgroTradeHub</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="cart-wrap">
<h1>🛒 My Shopping Cart</h1>
<a href="products.php">← Continue Shopping</a>

<?php if (!empty($_SESSION['cart'])): ?>
    <form method="post" action="">
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (৳)</th>
                    <th>Quantity</th>
                    <th>Subtotal (৳)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $grand_total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <?php
                        $subtotal = $item['price'] * $item['quantity'];
                        $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= number_format($item['price'],2) ?></td>
                        <td><input type="number" name="quantity[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1"></td>
                        <td><?= number_format($subtotal,2) ?></td>
                        <td><a href="?remove_index=<?= $index ?>" onclick="return confirm('Remove?')">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Total: ৳ <?= number_format($grand_total,2) ?></p>
        <button type="submit" name="update_cart">Update Cart</button>
    </form>

    <!-- Confirm Order Button -->
    <form method="post" action="order_confirmation.php">
        <button type="submit" name="confirm_order">Confirm Order</button>
    </form>

<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>
</div>
</body>
</html>
