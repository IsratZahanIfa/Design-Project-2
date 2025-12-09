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
    <title>Vegetables | AgroTradeHub</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
    background-color: #e0c3c3ff;
    font-family: 'Poppins', sans-serif;
    margin: 0;
}

.menu-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #024104;
    padding: 15px 25px;
    color: white;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
}

.menu-bar a {
    color: white;
    text-decoration: none;
    margin-right: 18px;
    font-size: 16px;
    transition: 0.3s;
}

.menu-bar a:hover {
    color: #e1ffcf;
}

.menu-right input[type="text"] {
    padding: 8px 12px;
    border-radius: 8px;
    border: none;
    outline: none;
    width: 200px;
}

.menu-right button {
    padding: 8px 16px;
    border-radius: 8px;
    background-color: #ffffff;
    color: #046f26;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: 0.3s;
}

.menu-right button:hover {
    background-color: #eaffea;
}


.section-heading {
    text-align: center;
    font-size: 34px;
    font-weight: 800;
    color: #05430d;
    margin-top: 40px;
    margin-bottom: 25px;
}


.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 25px;
    padding: 20px 40px;
}


.product-card {
    background: white;
    padding: 15px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: 0.3s;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.22);
}

.product-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
}

.product-card h3 {
    margin-top: 12px;
    font-size: 20px;
    color: #024104;
}

.price {
    font-size: 18px;
    font-weight: bold;
    color: #009e25;
}

.rating {
    margin: 7px 0;
}

.store, .location {
    font-size: 14px;
    color: #4d4d4d;
}

.btn-add-cart {
    margin-top: 12px;
    padding: 10px 12px;
    width: 100%;
    border: none;
    background-color: #024104;
    color: white;
    font-size: 16px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-add-cart:hover {
    background-color: #036c1e;
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
            <button type="submit"></button>
        </form>
    </div>
</div>

<!-- ========================= Vegetables SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Vegetable Products</h2>
    <div class="products-grid">
        <?php 
        $vegetables = [
            ["https://cdn.stocksnap.io/img-thumbs/280h/carrots-vegetable_KCSC4LAXLZ.jpg", "Carrot", 90 , "★★★★☆", "Veggie House", "Dhaka"],
            ["https://plantix.net/en/library/assets/custom/crop-images/potato.jpeg", "Potato", 50 , "★★★★★", "Farm Fresh BD", "Chattogram"],
            ["https://cdn.britannica.com/16/187216-050-CB57A09B/tomatoes-tomato-plant-Fruit-vegetable.jpg", "Tomato", 50 , "★★★★☆", "Organic Market", "Sylhet"],
            ["https://hub.suttons.co.uk/wp-content/uploads/2025/01/suttons.cabbage.sunta_.jpg", "Cabbage", 50 , "★★★★★", "Agro Store", "Rajshahi"],
            ["https://www.dailypost.net/media/imgAll/2023September/onion-20240422092135.jpg", "Onion", 100, "★★★★★", "Fresh Choice", "Khulna"],
            ["https://images.unsplash.com/photo-1524593410820-38510f580a77?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", "Green Chili", 50 , "★★★★☆", "Daily Veg Shop", "Barishal"]

        ];

        foreach ($vegetables as $item):
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
