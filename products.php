<?php 
include 'db.php';
$search ='';
if (isset($_GET['search'])) {
    $search = strtolower(trim($_GET['search']));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>
            body{
                margin: 0;
                padding: 0;
                min-height: 100vh;
                background: rgba(185, 142, 152, 0.4);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            .top-bar {
                width: 100%;
                background: #236b23d8;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .left-buttons {
                display: flex;
                gap: 25px;
                margin-left: 30px;
            }

            .left-buttons button {
                padding: 10px 35px;
                background: white;
                border: none;
                font-weight: 600;
                cursor: pointer;
                border-radius: 4px;
            }

            .search-area {
                display: flex;
                align-items: center;
                margin-right: 40px;
            }

            .search-area input {
                width: 350px;
                padding: 10px 15px 10px 40px;
                border-radius: 4px;
                border: none;
            }

            .search-area .icon {
                position: fixed;
                right: -35px;
                font-size: 18px;
                opacity: 0.8;
            }

            .content-area {
                width: 100%;
                background: #e3e3e3;
                padding-top: 40px;
                padding-bottom: 40px;
                min-height: 100vh;
            }

            .center-box {
                width: 400px;
                margin: auto;
                background: white;
                padding: 15px;
                text-align: center;
                border-radius: 4px;
                font-weight: 600;
            }

            .order-container {
                width: 80%;
                max-width: 900px;
                margin: 35px auto;
                background: rgba(255,255,255,0.8);
                padding: 25px;
                border-radius: 6px;
            }

            h2 {
                text-align: center;
                color: #003f0d;
                margin-bottom: 20px;
                font-size: 22px;
                font-weight: 700;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background: white;
                border-radius: 6px;
                overflow: hidden;
            }

            th {
                background: #003f0d;
                color: white;
                padding: 14px;
                font-size: 14px;
            }

            td {
                padding: 12px;
                border-bottom: 1px solid #ddd;
                font-size: 14px;
            }

            tr:hover {
                background: #f1f8f1;
            }
    </style>
</head>
<body>

<div class="menu-bar">
    <div class="menu-right">
        <a href="customer_dashboard.php">Home</a>
        <button type="button" onclick="window.location.href='products.php';">Refresh</button>
    </div>

    <div class="menu-right">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>

<section class="products-section">
    <h2 class="section-heading main-heading">Choose Your Products</h2>
</section>


<!-- ========================= FRUITS SECTION ========================= -->
 <?php if($search == '' || $search == 'fruits' || stripos ('fruits', $search) != false): ?>
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
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</section>
            <?php endif; ?>




<!-- ========================= VEGETABLE SECTION ========================= -->
  <?php if($search == '' || $search == 'vegetables' || stripos ('vegetables', $search) != false): ?>
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
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</section>
 <?php endif; ?>



<!-- ========================= Grains SECTION ========================= -->
  <?php if($search == '' || $search == 'grains' || stripos ('grains', $search) != false): ?>
<section class="product-section">
    <h2 class="section-heading">Grains Products</h2>

    <div class="products-grid">

        <?php 
        $grains = [
            ["https://t4.ftcdn.net/jpg/05/16/35/47/360_F_516354718_dPoyJgoRz2CQPNUuzzBbc6JCCfMRwrD9.jpg", "Bashmoti Chal", 300, "★★★★★", "FreshMart Store", "Dhaka, Bangladesh"],
            ["https://media.istockphoto.com/id/1322613316/photo/rice-in-wooden-bowl-on-rice-and-rice-ears-background-natural-food-high-in-protein.jpg?s=612x612&w=0&k=20&c=jYWVKwTwptgrFojDno7GW8x9iF2LakyoMTzzrZfY1tE=", "Jasmine Rice", 200, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSajDR2L0UIg3zPoE1cTr8KzCEsmLgVdH7qXw&s", "Mimicat Chal", 55 , "★★★★☆", "GrainHouse", "Chattogram"],
            ["https://m.media-amazon.com/images/I/61u0xglLd9L._AC_UF350,350_QL80_.jpg", "Atop Chal", 150, "★★★★★", "Green Store", "Dhaka, Bangladesh"],
            ["https://t4.ftcdn.net/jpg/00/36/46/19/360_F_36461980_U0C6iQqQ69HmWmkN3VufauKn4zKysdBC.jpg", "Uead Dal", 150, "★★★★★", "GrainHouse", "Khulna"],
            ["https://t4.ftcdn.net/jpg/02/92/43/21/360_F_292432153_HJwgwGCHSv6za5hhRz4pYZymXdhc4FiC.jpg", "Buckwheat",200, "★★★★☆", "Green Store", "Rajshahi"],
            ["https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5-aMEaoOTHkk6Jj441wSrTTP6xVtzakiwYA&s", "Green Peas", 300, "★★★★★", "Fruit Palace", "Sylhet"],
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
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</section>
 <?php endif; ?>


<!-- ========================= Fish SECTION ========================= -->
   <?php if($search == ''|| $search == 'fish' || stripos ('fish', $search) != false): ?>
<section class="product-section">
    <h2 class="section-heading">Fish Products</h2>

    <div class="products-grid">

        <?php 
        $fish = [
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

        foreach ($fish as $item):
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
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</section>
 <?php endif; ?>



<!-- ========================= SEED SECTION ========================= -->
  <?php if($search == ''|| $search == 'seeds' || stripos ('seeds', $search) != false): ?>
<section class="product-section">
    <h2 class="section-heading">Seed Products</h2>

    <div class="products-grid">

        <?php 
        $seeds = [
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

        foreach ($seeds as $item):
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
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</section>
 <?php endif; ?>


<!-- ========================= Trees SECTION ========================= -->
   <?php if($search == ''|| $search == 'trees' || stripos ('trees', $search) != false): ?>

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
                </form>
            </div>
        <?php endforeach; ?>

    </div>
</section>
 <?php endif; ?>


</body>
</html>
