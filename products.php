<?php 
// DB included only for future cart update checks (add_products table)
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<section class="product-section">
    <h2 class="section-heading main-heading">Choose Your Products</h2>
</section>




<!-- ========================= FRUITS SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Fruit Products</h2>

    <div class="products-grid">

        <?php 
        $fruits = [
            ["https://www.shutterstock.com/image-photo/red-apple-cut-half-water-600nw-2532255795.jpg", "Fresh Apples", 5.99, "★★★★★", "FreshMart Store", "Dhaka, Bangladesh"],
            ["https://t3.ftcdn.net/jpg/14/33/67/50/360_F_1433675088_KywMtAfZgtsIHPkkrnvw7vUiKoD1mLSp.jpg", "Organic Mango", 4.49, "★★★★☆", "AgroHub Shop", "Chattogram"],
            ["https://t3.ftcdn.net/jpg/04/86/61/74/360_F_486617409_HfTkXKIMRNdayEqPKwSzUajDcpayW0mJ.jpg", "Sweet Oranges", 3.99, "★★★★★", "Green Basket", "Khulna"],
            ["https://cdn.mos.cms.futurecdn.net/kNzSND7wrCuMDa8cGiw7mK.jpg", "Banana", 2.99, "★★★★☆", "Organic Valley", "Rajshahi"],
            ["https://www.rhs.org.uk/getmedia/1d3feaf7-8b23-48d6-a4dc-6255de263156/grape-dessert-varieties.jpg?width=940&height=627&ext=.jpg", "Fresh Grapes", 6.49, "★★★★★", "Fruit Palace", "Sylhet"],
            ["https://static.vecteezy.com/system/resources/previews/047/130/081/large_2x/pineapples-are-tropical-fruit-that-is-popular-fruit-in-hawaii-photo.jpg", "Pineapple", 3.49, "★★★★☆", "Daily Harvest", "Barishal"]
        ];

        foreach ($fruits as $item):
        ?>
            <div class="product-card">
                <img src="<?php echo $item[0]; ?>" class="product-img">
                
                <h3><?php echo $item[1]; ?></h3>

                <p class="price">৳ <?php echo number_format($item[2], 2); ?></p>

                <div class="rating"><?php echo $item[3]; ?></div>

                <p class="store"><strong>Store:</strong> <?php echo $item[4]; ?></p>
                <p class="location"><strong>Location:</strong> <?php echo $item[5]; ?></p>

                <form action="cart.php" method="POST">
                    <input type="hidden" name="name" value="<?php echo $item[1]; ?>">
                    <input type="hidden" name="price" value="<?php echo $item[2]; ?>">
                    <input type="hidden" name="image" value="<?php echo $item[0]; ?>">

                    <button type="submit" name="add_to_cart" class="btn-add-cart">
                        Add to Cart 🛒
                    </button>
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</section>





<!-- ========================= VEGETABLE SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Vegetable Products</h2>
    <div class="products-grid">
        <?php 
        $vegetables = [
            ["https://cdn.stocksnap.io/img-thumbs/280h/carrots-vegetable_KCSC4LAXLZ.jpg", "Carrot", "৳1.99 / kg", "★★★★☆", "Veggie House", "Dhaka"],
            ["https://plantix.net/en/library/assets/custom/crop-images/potato.jpeg", "Potato", "৳0.99 / kg", "★★★★★", "Farm Fresh BD", "Chattogram"],
            ["https://cdn.britannica.com/16/187216-050-CB57A09B/tomatoes-tomato-plant-Fruit-vegetable.jpg", "Tomato", "৳2.49 / kg", "★★★★☆", "Organic Market", "Sylhet"],
            ["https://hub.suttons.co.uk/wp-content/uploads/2025/01/suttons.cabbage.sunta_.jpg", "Cabbage", "৳1.49 / kg", "★★★★★", "Agro Store", "Rajshahi"],
            ["https://www.dailypost.net/media/imgAll/2023September/onion-20240422092135.jpg", "Onion", "৳3.49 / kg", "★★★★★", "Fresh Choice", "Khulna"],
            ["https://greenspices.in/wp-content/uploads/2021/07/black-pepper1.png", "Green Pepper", "৳2.99 / kg", "★★★★☆", "Daily Veg Shop", "Barishal"]
        ];

        foreach ($vegetables as $item) {
            echo "
            <div class='product-card'>
                <img src='{$item[0]}' class='product-img'>
                <h3>{$item[1]}</h3>
                <p class='price'>{$item[2]}</p>
                <div class='rating'>{$item[3]}</div>
                <p class='store'><strong>Store:</strong> {$item[4]}</p>
                <p class='location'><strong>Location:</strong> {$item[5]}</p>
            </div>";
        }
        ?>
    </div>
</section>





<!-- ========================= CROPS SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Crop Products</h2>

    <div class="products-grid">

        <?php 
        $crops = [
            ["rice.png", "Rice", "৳1.20 / kg", "★★★★★"],
            ["wheat.png", "Wheat", "৳1.10 / kg", "★★★★☆"],
            ["corn.png", "Corn", "৳1.50 / kg", "★★★★★"],
            ["barley.png", "Barley", "৳1.30 / kg", "★★★★☆"],
            ["millet.png", "Millet", "৳1.80 / kg", "★★★★☆"],
            ["soybean.png", "Soybean", "৳2.20 / kg", "★★★★★"]
        ];

        foreach ($crops as $item) {
            echo "
            <div class='product-card'>
                <img src='{$item[0]}' class='product-img'>
                <h3>{$item[1]}</h3>
                <p class='price'>{$item[2]}</p>
                <div class='rating'>{$item[3]}</div>
            </div>";
        }
        ?>

    </div>
</section>





<!-- ========================= SEED SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Seed Products</h2>

    <div class="products-grid">

        <?php 
        $seeds = [
            ["rice_seed.png", "Rice Seed", "৳3.50 / pack", "★★★★☆"],
            ["vegetable_seed.png", "Veg Seeds Pack", "৳2.80 / pack", "★★★★★"],
            ["flower_seed.png", "Flower Seeds", "৳1.50 / pack", "★★★★☆"],
            ["fruit_seed.png", "Fruit Seeds", "৳2.20 / pack", "★★★★★"],
            ["sunflower_seed.png", "Sunflower Seeds", "৳2.00 / pack", "★★★★☆"],
            ["pepper_seed.png", "Pepper Seeds", "৳3.00 / pack", "★★★★★"]
        ];

        foreach ($seeds as $item) {
            echo "
            <div class='product-card'>
                <img src='{$item[0]}' class='product-img'>
                <h3>{$item[1]}</h3>
                <p class='price'>{$item[2]}</p>
                <div class='rating'>{$item[3]}</div>
            </div>";
        }
        ?>

    </div>
</section>





<!-- ========================= TREE SECTION ========================= -->
<section class="product-section">
    <h2 class="section-heading">Tree Products</h2>

    <div class="products-grid">

        <?php 
        $trees = [
            ["mango_tree.png", "Mango Tree", "৳10.00 / plant", "★★★★★"],
            ["lemon_tree.png", "Lemon Tree", "৳8.50 / plant", "★★★★☆"],
            ["banana_tree.png", "Banana Tree", "৳7.00 / plant", "★★★★★"],
            ["guava_tree.png", "Guava Tree", "৳6.00 / plant", "★★★★☆"],
            ["jackfruit_tree.png", "Jackfruit Tree", "৳12.00 / plant", "★★★★★"],
            ["olive_tree.png", "Olive Tree", "৳9.00 / plant", "★★★★☆"]
        ];

        foreach ($trees as $item) {
            echo "
            <div class='product-card'>
                <img src='{$item[0]}' class='product-img'>
                <h3>{$item[1]}</h3>
                <p class='price'>{$item[2]}</p>
                <div class='rating'>{$item[3]}</div>
            </div>";
        }
        ?>

    </div>
</section>


</body>
</html>
