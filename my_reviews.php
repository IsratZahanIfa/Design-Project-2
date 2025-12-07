<?php
session_start();
include 'db.php';  // database connection

// If customer not logged in → redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = ""; // success or error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $store_name = mysqli_real_escape_string($conn, $_POST['store_name']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);   // ✅ NEW
    $rating = intval($_POST['rating']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    // Insert into review table (added store_name + product_name)
    $sql = "INSERT INTO reviews (user_id, name, store_name, product_name, rating, title, review, status)
            VALUES ($user_id, '$name', '$store_name', '$product_name', $rating, '$title', '$review', 'pending')";

    if (mysqli_query($conn, $sql)) {
        $message = "Your review has been submitted and is pending approval!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Write a Review</title>
    <style>
        body{
            background:#0f0f0f;
            color:white;
            font-family:Arial;
            padding:40px;
        }
        .container{
            max-width:700px;
            margin:auto;
        }
        input, textarea{
            width:100%;
            padding:12px;
            border-radius:6px;
            border:1px solid #333;
            background:#1a1a1a;
            color:white;
            font-size:14px;
            margin-bottom:20px;
        }
        .stars i{
            font-size:25px;
            cursor:pointer;
            color:#555;
        }
        .stars i.active{
            color:#ffcc00;
        }
        button{
            width:100%;
            background:white;
            border:none;
            padding:12px;
            border-radius:6px;
            font-size:16px;
            cursor:pointer;
        }
        .back-btn {
    display: inline-block;
    padding: 8px 15px;
    background: #222;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    margin-right: 15px;
}

.back-btn:hover {
    background: #444;
}

    </style>
</head>
<body>

<div class="container">

    <?php if ($message != ""): ?>
        <p style="background:#222; padding:10px; border-radius:5px;">
            <?= $message ?>
        </p>
    <?php endif; ?>

 
    <a href="customer_dashboard.php" class="back-btn">⬅ Back</a>

    <h3>My Review</h3>



    <form action="" method="POST">
        
        <label>Your Name *</label>
        <input type="text" name="name" required placeholder="Enter your name">

        <!-- Store Name -->
        <label>Store Name *</label>
        <input type="text" name="store_name" required placeholder="Enter the store name">

        <!-- 🔥 NEW: Product Name -->
        <label>Product Name *</label>
        <input type="text" name="product_name" required placeholder="Enter the product name">

        <label>Your Rating *</label>
        <div class="stars" id="rating-stars">
            <i data-value="1">★</i>
            <i data-value="2">★</i>
            <i data-value="3">★</i>
            <i data-value="4">★</i>
            <i data-value="5">★</i>
        </div>
        <input type="hidden" name="rating" id="rating" required>

        <label>Review Title *</label>
        <input type="text" name="title" required placeholder="Summarize your experience">

        <label>Your Review *</label>
        <textarea name="review" rows="5" required placeholder="Share your thoughts..."></textarea>

        <button type="submit">Submit Review</button>
    </form>
</div>

<script>
const stars = document.querySelectorAll('.stars i');
const ratingInput = document.getElementById('rating');

stars.forEach((star) => {
    star.addEventListener('click', function() {
        let rating = this.getAttribute("data-value");
        ratingInput.value = rating;

        stars.forEach(s => s.classList.remove("active"));
        for (let i = 0; i < rating; i++) {
            stars[i].classList.add("active");
        }
    });
});
</script>

</body>
</html>
