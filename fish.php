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
    <title>Fish | AgroTradeHub</title>
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
<<<<<<< HEAD
        </form>
    </div>
</div>

=======
            <button type="submit">Search</button>
        </form>
    </div>
</div>
>>>>>>> fc9d11989ef614d83355f711386ff22d50940c6c


<!-- ========================= Fish SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Fish Products</h2>
    <div class="products-grid">
        <?php
        $fruits = [
            ["https://media.istockphoto.com/id/2162360704/photo/fresh-hilsha-fish-displayed-for-sale-national-fish-of-bangladesh-hilsa.jpg?s=612x612&w=0&k=20&c=CLIdvJuZD_fIHN-p9YvTxLqFFEePS6Tyu78uo0-TxP8=", "Hilsha", 1000, "★★★★★", "FreshMart Store", "Dhaka, Bangladesh"],
            ["https://upload.wikimedia.org/wikipedia/commons/e/e0/Catla_catla.JPG", "Catla", 500, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://thumbs.dreamstime.com/b/pile-freshly-harvested-labeo-rohita-rohu-carp-fish-close-up-view-hd-381140940.jpg", "Rohu", 550 , "★★★★☆", "GrainHouse", "Chattogram"],
            ["https://www.shutterstock.com/image-photo/hilsa-fish-scientifically-known-tenualosa-600nw-2663057071.jpgg", "Hilsha", 850, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSv58EgDsYphJQqY6XFcF2MfatimNO_lJ9SPQ&s", "Mrigal", 550, "★★★★★", "GrainHouse", "Khulna"],
            ["https://t4.ftcdn.net/jpg/02/92/43/21/360_F_292432153_HJwgwGCHSv6za5hhRz4pYZymXdhc4FiC.jpg", "Buckwheat",200, "★★★★☆", "Green Store", "Rajshahi"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7DWjygtb8Gl1PvqmIaAH0SfqGyZFfFTI_ww&s", "Telapia", 300, "★★★★★", "FishHouse", "Sylhet"],
            ["https://media.istockphoto.com/id/500356812/photo/oats-and-milk.jpg?s=612x612&w=0&k=20&c=26_3gxNEyJz5HR4l9SUw7IFuklHcr6NI8yX_whKWJQE=", "Oats", 90, "★★★★☆", "Daily Harvest", "Barishal"],
            ["https://t4.ftcdn.net/jpg/00/36/46/19/360_F_36461980_U0C6iQqQ69HmWmkN3VufauKn4zKysdBC.jpg", "Uead Dal", 120, "★★★★★", "Green Store", "Khulna"],
            ["https://thumbs.dreamstime.com/b/pile-freshly-harvested-labeo-rohita-rohu-carp-fish-close-up-view-hd-381140940.jpg", "Rahu",600, "★★★★☆", "GrainHouse", "Rajshahi"],
            ["https://en.bdfish.org/wp-content/uploads/2010/02/cirrhinus_cirrhosus.jpg", "Mrigal", 600, "★★★★☆", "FishHouse", "Barishal"],
            ["https://media.istockphoto.com/id/500356812/photo/oats-and-milk.jpg?s=612x612&w=0&k=20&c=26_3gxNEyJz5HR4l9SUw7IFuklHcr6NI8yX_whKWJQE=", "Oats", 110, "★★★★☆", "GrainHouse", "Barishal"]
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

