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
=======
        background-color: rgba(184, 167, 167, 1);
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
        }
>>>>>>> fc9d11989ef614d83355f711386ff22d50940c6c
    </style>
</head>
<body>


<div class="menu-bar">
    <div class="menu-left">
        <a href="index.php"><i class="fa fa-home"></i> Home</a>
        <a href="customer_dashboard.php"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="menu-right">
        <form method="GET" action="">
           <input type="text" name="search" placeholder="Search products" value="<?= htmlspecialchars($search) ?>">
<<<<<<< HEAD
=======
    <button type="submit"></i> Search</button>


    <?php if ($search !== ""): ?>
     
        <button type="button" onclick="window.location.href='<?= $_SERVER['PHP_SELF'] ?>'">
            <i class="fa fa-refresh"></i> Refresh
        </button>
    <?php endif; ?>
>>>>>>> fc9d11989ef614d83355f711386ff22d50940c6c
        </form>
    </div>
</div>


<!-- ========================= FRUITS SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Fruit Products</h2>
    <div class="products-grid">
        <?php
        $fruits = [
            ["https://www.shutterstock.com/image-photo/red-apple-cut-half-water-600nw-2532255795.jpg", "Fresh Apples", 100, "★★★★★", "FreshMart Store", "Dhaka, Bangladesh"],
            ["https://media.istockphoto.com/id/478157668/photo/apple-background.jpg?s=612x612&w=0&k=20&c=_tkw1vIA9YzzpOFaUE7Al_gxAOj3AkhXsZ5VnGTY94U=", "Green Apples", 200, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://t3.ftcdn.net/jpg/14/33/67/50/360_F_1433675088_KywMtAfZgtsIHPkkrnvw7vUiKoD1mLSp.jpg", "Organic Mango", 120, "★★★★☆", "AgroHub Shop", "Chattogram"],
            ["https://bangladeshbiponee.com/wp-content/uploads/2023/05/Surma-Fazli-Mango-04.jpg", "Fajli Mango", 60, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://t3.ftcdn.net/jpg/04/86/61/74/360_F_486617409_HfTkXKIMRNdayEqPKwSzUajDcpayW0mJ.jpg", "Sweet Oranges", 200, "★★★★★", "Green Basket", "Khulna"],
            ["https://cdn.mos.cms.futurecdn.net/kNzSND7wrCuMDa8cGiw7mK.jpg", "Banana", 50, "★★★★☆", "Organic Valley", "Rajshahi"],
            ["https://www.rhs.org.uk/getmedia/1d3feaf7-8b23-48d6-a4dc-6255de263156/grape-dessert-varieties.jpg?width=940&height=627&ext=.jpg", "Fresh Grapes", 300, "★★★★★", "Fruit Palace", "Sylhet"],
            ["https://static.vecteezy.com/system/resources/previews/047/130/081/large_2x/pineapples-are-tropical-fruit-that-is-popular-fruit-in-hawaii-photo.jpg", "Pineapple", 50, "★★★★☆", "Daily Harvest", "Barishal"]
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
