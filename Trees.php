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
    <title>Trees | AgroTradeHub</title>
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

<!-- ========================= Trees SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Trees Products</h2>
    <div class="products-grid">
        <?php 
        $trees = [
            ["https://whiteonricecouple.com/recipe/images/lemon-tree-container-11-550x830-1.jpg", "Lemon Tree", 1200, "★★★★★", "Healthy Harvest", "Dhaka, Bangladesh"],
            ["https://ecdn.dhakatribune.net/contents/cache/images/640x359x1/uploads/media/2024/06/26/Mango-tree-b85b4094a33503041edc6446af1fcb24.JPG?jadewits_media_id=23165", "Dwarf Mango Tree", 2500, "★★★★☆", "GrainHouse", "Chattogram"],
            ["https://cdn.pixabay.com/photo/2016/07/26/15/01/guava-1543533_1280.jpg", "Guava Tree", 800, "★★★★★", "Daily Grain Mart", "Khulna"],
            ["https://everglades.farm/cdn/shop/articles/xebkllue-5-steps-to-grow-a-hawaiian-papaya-tree-successfully_bca5e9e1-fd8e-4ace-9b04-330814b3b4af.png?v=1751975682", "Papaya Tree", 500, "★★★★☆", "EcoGrain", "Rajshahi"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVr3yMEh4r63LWjQWPonG5wvLkuOVsb2jg2A&s", "Banana Plant", 300, "★★★★★", "Golden Grains", "Sylhet"],
            ["https://www.sainursery.com.au/uploads/editor/blobid1735024544299.jpg", "Curry Leaf Tree", 400, "★★★★☆", "Nature’s Basket", "Barishal"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRfaILK88Jn6jEmrkk8ptqKiX5z0OPfZRdhQ&s", "Dwarf Pomegranate Tree", 1500, "★★★★★", "EcoGrains", "Rajshahi"],
            ["https://m.media-amazon.com/images/I/81pg+PzGBCL._AC_UF1000,1000_QL80_.jpg", "Dwarf Jamun Tree", 1500, "★★★★★", "Healthy Harvest", "Dhaka, Bangladesh"],
            ["https://reemzbasket.com/cart/product/web/product/372.png", "Amla Tree", 600, "★★★★☆", "Daily Grain Mart", "Khulna"],
            ["https://plantandheal.com/cdn/shop/files/1C7652A3-D4E9-4AAC-983C-47DBC5A6DD78_530x@2x.jpg?v=1720217994", "Dwarf Pomegranate Tree", 1200, "★★★★★", "GrainHouse", "Rajshahi"],
            ["https://cdn.shopify.com/s/files/1/0059/8835/2052/files/Chicago_Hardy_Fig_2_BB_8e22fa96-7859-4aac-b057-cf7fdc0256ce.jpg?v=1739056481", "Fig Tree", 1000, "★★★★☆", "EcoGrain", "Sylhet"],
            ["https://florastore.com/cdn/shop/files/2014191_Atmosphere_01_SQ.jpg?v=1757668042&width=1080", "Dwarf Orange Tree", 900, "★★★★★", "Golden Grains", "Barishal"],
            ["https://whiteonricecouple.com/recipe/images/lemon-tree-container-11-550x830-1.jpg", "Lemon Tree", 1200, "★★★★★", "Healthy Harvest", "Dhaka, Bangladesh"],
            ["https://i.ytimg.com/vi/VV1fcLycA14/oardefault.jpg?sqp=-oaymwEYCJUDENAFSFqQAgHyq4qpAwcIARUAAIhC&rs=AOn4CLAKn-wvTfc6KztTGshH2XXPjCAzfg", "Dwarf Mango Tree", 3000, "★★★★☆", "Healthy Harvest", "Rajshahi"],
            ["https://m.media-amazon.com/images/I/714q8hi9FwL.jpg", "Guava Tree", 800, "★★★★★", "Daily Grain Mart", "Khulna"]
        ];

        foreach ($trees as $item):
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
