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
    <title>Grains | AgroTradeHub</title>
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
        </form>
    </div>
</div>


<!-- ========================= Grains SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Grains Products</h2>
    <div class="products-grid">
        <?php
        $grains = [
            ["https://t4.ftcdn.net/jpg/05/16/35/47/360_F_516354718_dPoyJgoRz2CQPNUuzzBbc6JCCfMRwrD9.jpg", "Bashmoti Chal", 300, "★★★★★", "FreshMart Store", "Dhaka, Bangladesh"],
            ["https://media.istockphoto.com/id/1322613316/photo/rice-in-wooden-bowl-on-rice-and-rice-ears-background-natural-food-high-in-protein.jpg?s=612x612&w=0&k=20&c=jYWVKwTwptgrFojDno7GW8x9iF2LakyoMTzzrZfY1tE=", "Jasmine Rice", 200, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSajDR2L0UIg3zPoE1cTr8KzCEsmLgVdH7qXw&s", "Mimicat Chal", 55 , "★★★★☆", "GrainHouse", "Chattogram"],
            ["https://m.media-amazon.com/images/I/61u0xglLd9L._AC_UF350,350_QL80_.jpg", "Atop Chal", 150, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://media.istockphoto.com/id/149147312/photo/hulled-millet-on-wooden-spoon-and-bowl.jpg?s=612x612&w=0&k=20&c=CeVz7_MWMDQE04bPTwFadLzAOMNwYz7kOLAHuC9S1_8=", "Millet", 120, "★★★★☆", "Daily Harvest", "Barishal"],
            ["https://media.istockphoto.com/id/500356812/photo/oats-and-milk.jpg?s=612x612&w=0&k=20&c=26_3gxNEyJz5HR4l9SUw7IFuklHcr6NI8yX_whKWJQE=", "Oats", 90, "★★★★☆", "Daily Harvest", "Barishal"],
            ["https://lindleymills.com/images/rye-grains-and-ears.jpg", "Rays", 150, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://t4.ftcdn.net/jpg/00/36/46/19/360_F_36461980_U0C6iQqQ69HmWmkN3VufauKn4zKysdBC.jpg", "Uead Dal", 120, "★★★★★", "Green Store", "Khulna"],
            ["https://img.freepik.com/free-photo/top-view-quinoa-with-wooden-spoon_140725-9086.jpg?semt=ais_hybrid&w=740&q=80", "Quinoat",100, "★★★★☆", "Green Store", "Rajshahi"],
            ["https://cdn.britannica.com/21/136021-050-FA97E7C7/Sorghum.jpg", "Sorghum", 250, "★★★★★", "GrainHouse", "Sylhet"],
            ["https://media.istockphoto.com/id/149147312/photo/hulled-millet-on-wooden-spoon-and-bowl.jpg?s=612x612&w=0&k=20&c=CeVz7_MWMDQE04bPTwFadLzAOMNwYz7kOLAHuC9S1_8=", "Millet", 170, "★★★★☆", "GrainHouse", "Barishal"],
            ["https://media.istockphoto.com/id/500356812/photo/oats-and-milk.jpg?s=612x612&w=0&k=20&c=26_3gxNEyJz5HR4l9SUw7IFuklHcr6NI8yX_whKWJQE=", "Oats", 110, "★★★★☆", "GrainHouse", "Barishal"]
        ];


        foreach ($grains as $item):
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
