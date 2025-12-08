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

    .bg-blur {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://storage.googleapis.com/48877118-7272-4a4d-b302-0465d8aa4548/8f263d79-144f-48d3-830f-185071cccc54/ad5d1ab1-f95b-46ae-a186-5d877f2e6719.jpg')
                    no-repeat center/cover;
        filter: blur(2px) brightness(0.9);
        z-index: -1;
        transform: scale(1.05); 
    }

    h2 {
        text-align: center;
        margin-top: 40px;
        font-size: 32px;
        color: #003509ff;
        letter-spacing: 1px;
        font-weight: 700;
        text-shadow: 0 2px 8px #0003;
    }

    .category-container {
        width: 100%;
        margin: 40px auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 35px;
    }

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

    .cat-name {
        padding: 18px;
        font-size: 16px;
        font-weight: 700;
        color: #013e0cff;
        letter-spacing: 0.5px;
    }

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
        z-index: 10; 
    }

    .back-btn:hover {
        background-color: #01360bff;
        color: white;
        transform: scale(1.05);
    }


.product-section .section-heading {
    text-align: center;
    font-size: 30px;
    font-weight: 800;
    color: rgb(0, 63, 13);
    margin-top: 40px;
    margin-bottom: 20px;
    animation: titleSlideUp 1s ease forwards;
    opacity: 0;
}

@keyframes titleSlideUp {
    0% { opacity: 0; transform: translateY(25px); }
    100% { opacity: 1; transform: translateY(0); }
}

.products-section {
    width: 95%;
    margin: 20px auto;
    font-weight: 800;
}

.product-section {
    width: 85%;
    margin: 18px auto;
}
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 25px;
}

.product-card {
    background: #ffffff;
    padding: 15px;
    text-align: center;
    border-radius: 12px;
    border: 1px solid #d7d7d7;
    transition: 0.3s ease-in-out;
}

.product-card:hover {
    box-shadow: 0 0 18px rgba(0,0,0,0.15);
    transform: translateY(-6px);
}

.product-card img {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border-radius: 8px;
    background: #f7f7f7;
    padding: 10px;
    transition: 0.3s ease;
}

.product-card img:hover {
    transform: scale(1.08);
}

.product-card h3 {
    font-size: 16px;
    margin: 10px 0 5px 0;
    font-weight: 600;
    color: rgb(0, 63, 13);
}

.price {
    color: rgb(0, 63, 13);
    font-size: 14px;
    font-weight: bold;
    margin-top: 6px;
}

.rating {
    font-size: 13px;
    color: #ff9800;
    margin-top: 5px;
}

.store, .location {
    font-size: 13px;
    color: #333;
    margin: 3px 0;
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
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-box {
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        .search-btn {
            padding: 7px 12px;
            border-radius: 8px;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-btn:hover {
            background-color: #e4e4e4;
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
            color:rgb(0, 63, 13);
            font-weight: bold;
            cursor: pointer;
        }

@media (max-width: 480px) {
    .products-grid {
        grid-template-columns: 1fr;
    }

    .menu-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .menu-right form {
        width: 100%;
    }

    .menu-right input[type="text"] {
        width: 70%;
        margin-bottom: 5px;
    }

    .menu-right button {
        width: 25%;
    }
}

</style>

</head>
<body>
    <div class="bg-blur"></div>

    <h2>All Categories</h2>

    <div class="category-container">
<<<<<<< HEAD

    <?php foreach ($categories as $cat): 
        $page = strtolower($cat['name']) . ".php";
    ?>
        <a href="<?php echo htmlspecialchars($page); ?>" class="cat-card">
            <img src="<?php echo htmlspecialchars($cat['image']); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>">
            <div class="cat-name"><?php echo htmlspecialchars($cat['name']); ?></div>
        </a>
    <?php endforeach; ?>
</div>

=======
>>>>>>> 62c5a44f9e8bd300171a95509207e39cf8e5796e

    <?php foreach ($categories as $cat): 
        $page = strtolower($cat['name']) . ".php";
    ?>
        <a href="<?php echo htmlspecialchars($page); ?>" class="cat-card">
            <img src="<?php echo htmlspecialchars($cat['image']); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>">
            <div class="cat-name"><?php echo htmlspecialchars($cat['name']); ?></div>
        </a>
    <?php endforeach; ?>
</div>


    <a href="customer_dashboard.php" class="back-btn">Back to Dashboard</a>

    
</body>
</html>
