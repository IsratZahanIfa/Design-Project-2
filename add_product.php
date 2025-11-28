<?php
session_start();
include 'db.php';

// Prevent non-seller access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}


// Get seller info
$seller_id = $_SESSION['user_id'];
$seller_sql = "SELECT email FROM users WHERE id = '$seller_id'";
$seller_result = mysqli_query($conn, $seller_sql);
$seller_row = mysqli_fetch_assoc($seller_result);
$seller_email = $seller_row['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $category   = mysqli_real_escape_string($conn, $_POST['category']);
    $price      = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity   = mysqli_real_escape_string($conn, $_POST['quantity']);
    $store_name = mysqli_real_escape_string($conn, $_POST['store_name']);
    $location   = mysqli_real_escape_string($conn, $_POST['location']);
    
    $sql = "INSERT INTO add_products 
        (seller_id, seller_email, name, category, price, quantity, store_name, location) 
        VALUES 
        ('$seller_id', '$seller_email', '$name', '$category', '$price', '$quantity', '$store_name', '$location')";

    if (mysqli_query($conn, $sql)) {
        $message = "✅ Product added successfully!";
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Product | AgroTradeHub</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Add New Product</h2>

    <?php if(!empty($message)): ?>
        <p class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" placeholder="Enter product name" required>

        <label for="category">Category</label>
        <select name="category" id="category" required onchange="updateUnit()">
            <option value="">--Select Category--</option>
            <option value="fruit">Fruit</option>
            <option value="vegetable">Vegetable</option>
            <option value="crop">Crop</option>
            <option value="tree">Tree</option>
            <option value="seed">Seed</option>
        </select>

        <label for="price">Price (৳)</label>
        <input type="number" name="price" id="price" placeholder="Enter product price" required>

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" placeholder="Enter available quantity" min="1" required>
        <span id="unit-span">kg</span>

        <script>
        function updateUnit() {
            const category = document.getElementById('category').value;
            const unitSpan = document.getElementById('unit-span');
            unitSpan.textContent = (category === 'seed' || category === 'tree') ? '' : 'kg';
        }
        </script>

        <label for="store_name">Store Name</label>
        <input type="text" name="store_name" id="store_name" placeholder="Store Name" required>

        <label for="location">Location</label>
        <input type="text" name="location" id="location" placeholder="Location" required>

        <div class="button-group">
            <button type="submit" class="btn-submit">Add Product</button>
            <button type="button" class="btn-close" onclick="window.location.href='seller_dashboard.php';">Close</button>
        </div>
    </form>
</div>

</body>
</html>
