<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$search = '';
if (isset($_GET['search'])) {
    $search = strtolower(trim($_GET['search']));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fruits | AgroTradeHub</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
        background-color: rgba(221, 197, 197, 1);
    }
        .menu-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgb(0, 63, 19);
            padding: 10px 20px;
            color: white;
            font-weight: bold;
        }
        .menu-bar a {
            color: white;
            text-decoration: none;
            margin-right: 12px;
        }
        .menu-bar a:hover {
            text-decoration: underline;
        }
        .menu-left, .menu-right {
            display: flex;
            align-items: center;
        }
        .menu-right form {
            display: inline;
        }
        .menu-right input[type="text"] {
            padding: 0;
            border-radius: 5px;
            border: none;
            margin-right: 10px;
        }
        .menu-right button {
            padding:0;
            border-radius: 5px;
            border: none;
            background-color: #fefefe;
            color: green;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="menu-bar">
    <div class="menu-left">
        <a href="customer_dashboard.php"><i class="fa fa-home"></i> Home</a>
        <a href="javascript:history.back()"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="menu-right">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products" value="<?= htmlspecialchars($search) ?>">
            <button type="submit"><i class="fa fa-search"></i> </button>
        </form>
        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<!-- ========================= FRUITS SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Vegetable Products</h2>
    <div class="products-grid">
        <?php 
        $fruits = [
           ["https://cdn.stocksnap.io/img-thumbs/280h/carrots-vegetable_KCSC4LAXLZ.jpg", "Carrot", 90 , "★★★★☆", "Veggie House", "Dhaka"],
            ["https://plantix.net/en/library/assets/custom/crop-images/potato.jpeg", "Potato", 50 , "★★★★★", "Farm Fresh BD", "Chattogram"],
            ["https://cdn.britannica.com/16/187216-050-CB57A09B/tomatoes-tomato-plant-Fruit-vegetable.jpg", "Tomato", 50 , "★★★★☆", "Organic Market", "Sylhet"],
            ["https://hub.suttons.co.uk/wp-content/uploads/2025/01/suttons.cabbage.sunta_.jpg", "Cabbage", 50 , "★★★★★", "Agro Store", "Rajshahi"],
            ["https://www.dailypost.net/media/imgAll/2023September/onion-20240422092135.jpg", "Onion", 100, "★★★★★", "Fresh Choice", "Khulna"],
            ["https://greenspices.in/wp-content/uploads/2021/07/black-pepper1.png", "Green Pepper", 50 , "★★★★☆", "Daily Veg Shop", "Barishal"]
        ];

        foreach ($fruits as $item):
        ?>
            <div class="product-card">
                <img src="<?= $item[0] ?>" class="product-img">
                <h3><?= $item[1] ?></h3>
                <p class="price">৳ <?= number_format($item[2], 2) ?></p>
                <div class="rating"><?= $item[3] ?></div>
                <p class="store"><strong>Store:</strong> <?= $item[4] ?></p>
                <p class="location"><strong>Location:</strong> <?= $item[5] ?></p>

                <form action="cart.php" method="POST">
                    <input type="hidden" name="product_name" value="<?= $item[1] ?>">
                    <input type="hidden" name="price" value="<?= $item[2] ?>">
                    <input type="hidden" name="store_name" value="<?= $item[4] ?>">
                    <button type="submit" name="add_to_cart" class="btn-add-cart">
                        Add to Cart 🛒
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>

</body>
</html>
