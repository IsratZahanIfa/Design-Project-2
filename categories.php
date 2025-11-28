<?php
session_start();

/* -------------------------
   CATEGORY LIST (NO DATABASE)
--------------------------- */
$categories = [
    [
        "name" => "Fruits",
        "image" => "https://cdn.pixabay.com/photo/2013/02/17/12/24/fruits-82524_1280.jpg"
    ],
    [
        "name" => "Vegetables",
        "image" => "https://thumbs.dreamstime.com/b/fruit-vegetables-7134858.jpg"
    ],
    [
        "name" => "Grains",
        "image" => "https://t4.ftcdn.net/jpg/02/44/16/79/360_F_244167973_E7aRgY9NHX9qW0QWOaZNwmG8NBJaa1rf.jpg"
    ],
    [
        "name" => "Fish",
        "image" => "https://www.shutterstock.com/image-photo/ilish-hilsa-fish-being-displayed-600nw-2473100745.jpg"
    ],
    [
        "name" => "Seeds",
        "image" => "https://www.shutterstock.com/image-photo/planting-concept-melon-seeds-soil-260nw-2253178585.jpg"
    ],
    [
        "name" => "Crops",
        "image" => "https://www.shutterstock.com/image-photo/low-anlgle-view-agriculture-farming-600nw-2472323883.jpg"
    ],
    [
        "name" => "Trees",
        "image" => " https://thumbs.dreamstime.com/b/environment-earth-day-hands-trees-growing-seedlings-bokeh-green-background-female-hand-holding-tree-nature-field-118143566.jpg"
    ]
   
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow-x: hidden;
    }

    /* ===== Blurred Background Image ===== */
    .bg-blur {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://storage.googleapis.com/48877118-7272-4a4d-b302-0465d8aa4548/8f263d79-144f-48d3-830f-185071cccc54/ad5d1ab1-f95b-46ae-a186-5d877f2e6719.jpg')
                    no-repeat center/cover;
        filter: blur(12px) brightness(0.7);
        z-index: -1;
        transform: scale(1.05); /* removes border blur edges */
    }

    /* ===== Heading ===== */
    h2 {
        text-align: center;
        margin-top: 40px;
        font-size: 32px;
        color: #003509ff;
        letter-spacing: 1px;
        font-weight: 700;
        text-shadow: 0 2px 8px #0003;
    }

    /* ===== Category Grid ===== */
    .category-container {
        width: 100%;
        margin: 40px auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 35px;
    }

    /* ===== Category Card ===== */
    .cat-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(18px);
        border-radius: 18px;
        overflow: hidden;
        text-align: center;
        box-shadow: 0 6px 20px #0003;
        transition: all 0.35s ease;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .cat-card:hover {
        transform: translateY(-8px) scale(1.06);
        box-shadow: 0 15px 25px #0004;
        background: rgba(255, 255, 255, 0.85);
    }

    .cat-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-bottom: 1px solid #fff5;
    }

    /* ===== Category Name Text ===== */
    .cat-name {
        padding: 18px;
        font-size: 16px;
        font-weight: 700;
        color: #013e0cff;
        letter-spacing: 0.5px;
    }

    /* Back Button Styles */
    .back-btn {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 10px 20px;
        font-size: 14px;
        background-color: #ffffffff;
        color: green;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 10px #0003;
        transition: 0.3s;
        z-index: 10; /* ensures it stays above other elements */
    }

    .back-btn:hover {
        background-color: #01360bff;
        transform: scale(1.05);
    }

</style>

</head>
<body>
    <div class="bg-blur"></div>

    <h2>All Categories</h2>

    <div class="category-container">
        <?php foreach ($categories as $cat) { ?>
            <div class="cat-card">
                <img src="<?php echo $cat['image']; ?>" alt="<?php echo $cat['name']; ?>">
                <div class="cat-name"><?php echo $cat['name']; ?></div>
            </div>
        <?php } ?>
    </div>

    <!-- Back Button (Top-Left Corner) -->
    <button onclick="history.back()" class="back-btn">Back</button>

    
</body>
</html>
