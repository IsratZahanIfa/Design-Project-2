<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
    header("Location: login.php");
    exit();
}

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
        $message = "Product added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
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
        width: 50%;
        margin: 40px auto;
        background: rgba(255, 182, 192, 0.28);
        padding: 35px 60px;
        border-radius: 8px;
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        box-shadow: 0 0 18px rgba(0, 0, 0, 0.35);
        text-align: left;
         animation: fadeIn 0.4s ease;
    }

    .container h2 {
    text-align: center;
    margin-bottom: 25px;
    color: rgb(0, 63, 13);
    font-size: 22px;
    font-weight: 700;
}

label {
    font-size: 14px;
    font-weight: 600;
    display: block;
    margin-top: 12px;
    color: black;
}

input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 10px 12px;
    font-size: 12px;
    margin-top: 6px;
    border: 1px solid #292929ff;
    border-radius: 4px;
    outline: none;
}



.button-group {
    margin-top: 30px;
    display: flex;
    justify-content: flex-start; 
    align-items: center;
    gap: 60px;
}

.bttn-submit, 
.bttn-close {
    width: 170px;
    padding: 10px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    background: rgb(0, 63, 13);  
    color: white; 
    transition: 0.2s ease-in-out;                
}


.bttn-submit:hover,
.bttn-close:hover {
    background: rgb(3, 19, 0);
    color: white;
}

            </style>
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
            <button type="submit" class="bttn-submit">Add Product</button>
            <button type="button" class="bttn-close" onclick="window.location.href='seller_dashboard.php';">Close</button>
        </div>
    </form>
</div>

</body>
</html>
