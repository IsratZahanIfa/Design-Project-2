<?php
session_start();

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
        "name" => "Trees",
        "image" => "https://thumbs.dreamstime.com/b/environment-earth-day-hands-trees-growing-seedlings-bokeh-green-background-female-hand-holding-tree-nature-field-118143566.jpg"
    ]
   
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        position: relative;
        overflow-x: hidden;
    }
</style>

</head>
<body>
    <div class="bg-blur"></div>

    <h2>All Categories</h2>

    <div class="category-container">

    <?php foreach ($categories as $cat): 
        $page = strtolower($cat['name']) . ".php";
    ?>
        <a href="<?php echo htmlspecialchars($page); ?>" class="cat-card">
            <img src="<?php echo htmlspecialchars($cat['image']); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>">
            <div class="cat-name"><?php echo htmlspecialchars($cat['name']); ?></div>
        </a>
    <?php endforeach; ?>
</div>


    <button onclick="history.back()" class="back-btn">Back</button>

    
</body>
</html>
