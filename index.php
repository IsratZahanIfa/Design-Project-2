<?php session_start(); 

include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agri Trade Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="topbar">
        <div class="container topbar__inner">
            <div class="topbar__contact">
                <span>📞 <a href="tel:01625553255">01625-324255</a></span>
                <span class="divider">|</span>
                <span>✉️ <a href="mailto:support@agrotradehub.com">support@agrotradehub.com</a></span>
            </div>
            <div class="topbar__cta">
                <a class="btn btn-xxs btn-light" href="register.php" aria-label="Become a customer">Become a customer</a>
            </div>
        </div>
    </div>

        <header class="site-header">
            <div class="container header__inner">
                <a href="index.php" class="brand" aria-label="Home">
                    <span class="brand__mark">🍃</span>
                    <span class="brand__text">Agri Trade Hub</span>
                </a>
            <nav id="site-nav" class="nav">
                <ul>
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="reviews.php">Review</a></li>
                     <li><a href="notifications.php">Notification</a></li>
                </ul>
            </nav>
            <div class="nav-icons">
                <a href="product.php"><i class="fa fa-search"></i></a>
                <a href="cart.php"><i class="fa fa-shopping-cart"></i></a>
                <a href="admin.php"><i class="fa fa-user"></i></a>
            </div>

        </div>
    </header>

<section class="hero">

    <div class="nav-right">
        <a href="login.php" class="btn-outline">Login</a>
        <a href="register.php" class="btn-outline">Register</a>
    </div>

    <div class="container hero__grid">

    <div class="container hero__grid">
        <h1 style="margin_bottom: 25px; font_size: 20; color: #00340aef; font-weight:800;">Agricultural Product Sellers are Connected with those in need</h1>
        <p style="font_size: 14; color: #000; font-weight:700;">Join our community and help to purchase any product.</p>
        <div>
            
        <div style="margin-bottom: 25px;">
            <a href="products.php" class="btn-white">Find Products</a>
            <a href="order.php" class="btn-white">Request For Ordering</a>
        </div>

    </div>
</section>


    <!-- About Us Section -->
    <section class="about-us">
        <div class="container">
            <h2>About AgroTradeHub</h2>
            <p>AgroTradeHub হল এমন একটি প্ল্যাটফর্ম যা কৃষক, বিক্রেতা এবং গ্রাহকদের সাথে সংযোগ স্থাপন করে একটি সমৃদ্ধ কৃষি সম্প্রদায় তৈরি করে। আমাদের লক্ষ্য সহজ: কৃষি খাতের সকলের জন্য তাজা পণ্য, ন্যায্য বাণিজ্য এবং নিরবচ্ছিন্ন লেনদেনের সুযোগ প্রদান।</p>
            
            <div class="about-us__grid">
                <div class="about-us__card">
                    <h3><i class="fas fa-seedling" style="color:var(--brand);margin-right:8px;"></i>Support Farmers</h3>
                    <p>We empower farmers by giving them a platform to sell their products directly to consumers, ensuring fair pricing and wider reach.</p>
                </div>
                <div class="about-us__card">
                    <h3><i class="fas fa-shopping-cart" style="color:var(--brand);margin-right:8px;"></i>Convenient Shopping</h3>
                    <p>Customers can easily browse, filter, and order fresh agricultural products from trusted sellers with a few clicks.</p>
                </div>
                <div class="about-us__card">
                    <h3><i class="fas fa-chart-line" style="color:var(--brand);margin-right:8px;"></i>Grow Together</h3>
                    <p>By connecting all stakeholders in one place, we build a sustainable ecosystem that benefits sellers, buyers, and the agriculture community as a whole.</p>
                </div>
            </div>
            
            <div class="about-us__cta">
                <p>আমাদের কমিউনিটিতে যোগদান করুন এবং যেকোনো পণ্য কিনতে সাহায্য করুন!</p>
                <a href="register.php" class="btn btn-lg btn-primary" style="font-weight:700;">Join the Community</a>

            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
    <div class="container">
        <h2 class="section-title">Our Services</h2>

        <div class="service-cards">

            <div class="service-card">
                <div class="service-icon">
                   <i class="fas fa-leaf service__icon"></i>
                </div>
                <h3>Fresh Produce</h3>
                <p>Get freshly harvested vegetables and fruits directly from trusted farmers.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                   <i class="fas fa-store service__icon"></i>
                </div>
                <h3>Seller Marketplace</h3>
                <p>Connect with verified sellers and buy quality agricultural products at fair prices.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                 <i class="fas fa-truck service__icon"></i>
                </div>
                <h3>Fast Delivery</h3>
                <p>Your trusted platform for agribusiness, farmer support, and quality product delivery.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-chart-pie service__icon"></i>
                </div>
                <h3>Insight & Reports</h3>
                <p>Get agricultural insights, product trends, and price updates to support smart decisions.</p>
            </div>

        </div>
    </div>
</section>


    <!-- Footer Section -->
    <footer class="footer">
    <div class="footer-container">
        <div class="footer-col">
            <h2 class="footer-logo">Agro Trade Hub</h2>
            <p>Your trusted platform for agriculture trading, farmer support, and quality product delivery.</p>

            <div class="footer-social">
                <a href="https://twitter.com"><i class="fab fa-twitter"></i></a> 
                <a href="https://wa.me"><i class="fab fa-whatsapp"></i></a> 
                <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">Seller Registration</a></li>
                <li><a href="#">Become a Customer</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Services</h4>
            <ul>
                <li><a href="#">Order Support</a></li>
                <li><a href="#">Delivery Info</a></li>
                <li><a href="#">Refund Policy</a></li>
                <li><a href="#">Help Center</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact Us</h4>
            <p>Email: support@agrotradehub.com</p>
            <p>Phone: +880 1234 567890</p>
            <p>Address: Dhaka, Bangladesh</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2025 Agro Trade Hub — All Rights Reserved</p>
    </div>
</footer>



    <script>
        const toggle = document.querySelector('.nav-toggle');
        const nav = document.getElementById('site-nav');

        if (toggle && nav) {
            toggle.addEventListener('click', () => {
                const open = nav.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }
    </script>

    <script>
    const searchIcon = document.querySelector('.fa-search');
    const searchBox = document.getElementById('search-box');

    if (searchIcon && searchBox) {
        searchIcon.addEventListener('click', () => {
            // Toggle the visibility
            if (searchBox.style.display === "block") {
                searchBox.style.display = "none";
            } else {
                searchBox.style.display = "block";
            }
        });
    }
</script>

    
</body>
</html>