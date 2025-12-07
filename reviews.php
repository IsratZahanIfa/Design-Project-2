<?php
include 'db.php';
session_start();

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch logged-in user's name from users table as fallback
$user_name = '';
$user_q = mysqli_query($conn, "SELECT name FROM users WHERE id = '". intval($user_id) ."' LIMIT 1");
if ($user_q && mysqli_num_rows($user_q) > 0) {
    $ud = mysqli_fetch_assoc($user_q);
    $user_name = $ud['name'];
}

// Add review
if (isset($_POST['add_review'])) {
    // sanitize inputs
    $store_name = mysqli_real_escape_string($conn, trim($_POST['store_name'] ?? ''));
    $comment = mysqli_real_escape_string($conn, trim($_POST['comment'] ?? ''));
    $rating = intval($_POST['rating'] ?? 0);

    // use session/user name as full_name fallback
    $full_name = mysqli_real_escape_string($conn, $user_name ?: 'Customer');

    // Basic validation
    if ($store_name === '') {
        $store_name = 'Unknown';
    }
    if ($rating < 1 || $rating > 5) {
        $rating = 5;
    }

    $ins_sql = "INSERT INTO reviews (user_id, full_name, store_name, rating, comment, created_at)
                VALUES ('$user_id', '$full_name', '$store_name', '$rating', '$comment', NOW())";
    mysqli_query($conn, $ins_sql);
}

$reviews_sql = "SELECT r.*, u.name AS user_name FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                ORDER BY r.created_at DESC";
$reviews = mysqli_query($conn, $reviews_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>
    <link rel="stylesheet" href="review.css">
</head>
<body class="review-body">

<div class="review-container">
    <h2>Customer Reviews</h2>

    <!-- Add Review -->
    <form method="POST" class="review-form">
        <label>Store Name:</label>
        <input type="text" name="store_name" required>

        <label>Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required>

        <label>Comment:</label>
        <textarea name="comment" rows="3" required></textarea>

        <button type="submit" name="add_review" class="review-btn">Submit Review</button>
    </form>

    <hr class="hr-line">

    <!-- Display Reviews -->
    <?php
    if ($reviews && mysqli_num_rows($reviews) > 0) {
        while ($row = mysqli_fetch_assoc($reviews)) {
            // Use DB column if exists, otherwise fallback to joined user_name or 'Anonymous'
            $display_name = isset($row['full_name']) && $row['full_name'] !== '' ? $row['full_name']
                          : (isset($row['user_name']) && $row['user_name'] !== '' ? $row['user_name'] : 'Anonymous');

            $display_store = isset($row['store_name']) && $row['store_name'] !== '' ? $row['store_name'] : 'N/A';
            $display_rating = isset($row['rating']) ? intval($row['rating']) : 0;
            $display_comment = isset($row['comment']) ? $row['comment'] : '';
            $display_time = isset($row['created_at']) ? $row['created_at'] : '';
            ?>
            <div class="review-box">
                <strong><?php echo htmlspecialchars($display_name); ?></strong>
                <span class="rating">[<?php echo $display_rating; ?>/5]</span><br>

                <small class="store-name">
                    Store: <?php echo htmlspecialchars($display_store); ?>
                </small><br>

                <p><?php echo nl2br(htmlspecialchars($display_comment)); ?></p>

                <small class="time"><?php echo htmlspecialchars($display_time); ?></small>
            </div>
        <?php
        }
    } else {
        echo "<p>No reviews yet.</p>";
    }
    ?>

    <a href="index.php" class="back-btn">Back</a>
</div>

</body>
</html>
