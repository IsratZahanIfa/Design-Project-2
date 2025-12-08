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
<<<<<<< HEAD
        background-color: rgba(221, 197, 197, 1);
=======
        background-color: rgba(184, 167, 167, 1);
>>>>>>> 62c5a44f9e8bd300171a95509207e39cf8e5796e
    }
        .menu-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
<<<<<<< HEAD
            background-color: #024104ff;
=======
            background: rgb(0, 63, 19);
>>>>>>> 62c5a44f9e8bd300171a95509207e39cf8e5796e
            padding: 10px 20px;
            color: white;
            font-weight: bold;
        }
        .menu-bar a {
            color: white;
            text-decoration: none;
<<<<<<< HEAD
            margin-right: 15px;
=======
            margin-right: 12px;
>>>>>>> 62c5a44f9e8bd300171a95509207e39cf8e5796e
        }
        .menu-bar a:hover {
            text-decoration: underline;
        }
        .menu-left, .menu-right {
            display: flex;
            align-items: center;
        }
<<<<<<< HEAD
        .menu-right form {
            display: inline;
        }
        .menu-right input[type="text"] {
            padding: 5px;
            border-radius: 5px;
            border: none;
            margin-right: 5px;
        }
        .menu-right button {
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            background-color: #fefefe;
            color: green;
            font-weight: bold;
            cursor: pointer;
=======
        .menu-right {
            display: flex;
            align-items: center;
        }

        .menu-right form {
            display: flex;
            align-items: center;
        }

        .menu-right input[type="text"] {
            padding: 8px 15px;
            border-radius: 25px;
            border: none;
            outline: none;
            width: 220px;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .menu-right input[type="text"]:focus {
            width: 260px;
            background: #fff;
>>>>>>> 62c5a44f9e8bd300171a95509207e39cf8e5796e
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
<<<<<<< HEAD
            <button type="submit"><i class="fa fa-search"></i> Search</button>
        </form>
        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<!-- ========================= FRUITS SECTION ========================= -->
=======
            <button type="submit"> Search</button>
        </form>
    </div>
</div>

<<<<<<< HEAD
<!-- ========================= FRUITS SECTION ========================= -->
=======
<!-- ========================= Trees SECTION ========================= -->
>>>>>>> e789c2fcd28f0a8bea336e2a9eff0892198de6e2
>>>>>>> 62c5a44f9e8bd300171a95509207e39cf8e5796e
<section class="product-section">
    <h2 class="section-heading">Trees Products</h2>
    <div class="products-grid">
        <?php 
        $fruits = [
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
<<<<<<< HEAD
            ["https://cdn.pixabay.com/photo/2016/07/26/15/01/guava-1543533_1280.jpg", "Guava Tree", 800, "★★★★★", "Daily Grain Mart", "Khulna"]
=======
            ["https://m.media-amazon.com/images/I/714q8hi9FwL.jpg", "Guava Tree", 800, "★★★★★", "Daily Grain Mart", "Khulna"]
>>>>>>> 62c5a44f9e8bd300171a95509207e39cf8e5796e
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
