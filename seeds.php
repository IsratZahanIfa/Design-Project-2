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
            background-color: #024104ff;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
        }
        .menu-bar a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
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
            <button type="submit"><i class="fa fa-search"></i> Search</button>
        </form>
        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<!-- ========================= FRUITS SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Seeds Products</h2>
    <div class="products-grid">
        <?php 
        $fruits = [
             ["https://media.istockphoto.com/id/1152072821/photo/fennel-seeds-in-a-bowl-on-a-wooden-table.jpg?s=612x612&w=0&k=20&c=HMu6k6N56BnV465K015xvPRuzAqJWT7iUxnww1qPXyA=", "Fennel Seeds", 300, "★★★★★", "FreshMart Store", "Dhaka, Bangladesh"],
            ["https://media.istockphoto.com/id/524901568/photo/coriander-seeds-and-leaves.jpg?s=612x612&w=0&k=20&c=yvikp5gpdF_eKE0qElg5V0v4cj2g-_FlIGZNWjZYNDU=", "Coriander Seeds", 200, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://media.post.rvohealth.io/wp-content/uploads/sites/3/2020/02/323037_2200-800x1200.jpg", "Hemp Seeds", 300, "★★★★☆", "GrainHouse", "Chattogram"],
            ["https://t3.ftcdn.net/jpg/04/36/98/96/360_F_436989686_PPLp8Vo0atNIyD8rvtm8hN3y4R9YBvvQ.jpg", "Mustard Seedsl", 150, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://m.media-amazon.com/images/I/61YTlxjXe9L._AC_UF1000,1000_QL80_.jpg", "Fenugreek Seeds", 120, "★★★★★", "GrainHouse", "Khulna"],
            ["https://cdn.britannica.com/59/219359-050-662D86EA/Cumin-Spice.jpg", "Cumin",200, "★★★★☆", "Green Store", "Rajshahi"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5-aMEaoOTHkk6Jj441wSrTTP6xVtzakiwYA&s", "Green Peas", 200, "★★★★★", "EcoGrain", "Sylhet"],
            ["https://media.istockphoto.com/id/598149032/photo/green-cardamom.jpg?s=612x612&w=0&k=20&c=khOIaZKRBsbl82sJWOfJVvl0OkMaNPZSNM3_vE-Zylc=", "Cardamom Seeds", 120, "★★★★☆", "Daily Harvest", "Barishal"],
            ["https://media.istockphoto.com/id/500356812/photo/oats-and-milk.jpg?s=612x612&w=0&k=20&c=26_3gxNEyJz5HR4l9SUw7IFuklHcr6NI8yX_whKWJQE=", "Oats", 90, "★★★★☆", "Daily Harvest", "Barishal"],
            ["https://lindleymills.com/images/rye-grains-and-ears.jpg", "Rays", 150, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://t4.ftcdn.net/jpg/00/36/46/19/360_F_36461980_U0C6iQqQ69HmWmkN3VufauKn4zKysdBC.jpg", "Uead Dal", 120, "★★★★★", "Green Store", "Khulna"],
            ["https://img.freepik.com/free-photo/top-view-quinoa-with-wooden-spoon_140725-9086.jpg?semt=ais_hybrid&w=740&q=80", "Quinoat",100, "★★★★☆", "Green Store", "Rajshahi"],
            ["https://cdn.britannica.com/21/136021-050-FA97E7C7/Sorghum.jpg", "Sorghum", 250, "★★★★★", "GrainHouse", "Sylhet"],
            ["https://media.istockphoto.com/id/149147312/photo/hulled-millet-on-wooden-spoon-and-bowl.jpg?s=612x612&w=0&k=20&c=CeVz7_MWMDQE04bPTwFadLzAOMNwYz7kOLAHuC9S1_8=", "Millet", 170, "★★★★☆", "GrainHouse", "Barishal"],
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
