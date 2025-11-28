<?php
include 'db.php';
session_start();

// Redirect if user not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Add review
if(isset($_POST['add_review'])){
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating = intval($_POST['rating']);
    $user_id = $_SESSION['user_id'];

    mysqli_query($conn, "INSERT INTO reviews (user_id, rating, comment, created_at) 
        VALUES ('$user_id', '$rating', '$comment', NOW())");
}

// Fetch all reviews
$reviews = mysqli_query($conn, "SELECT r.*, u.name FROM reviews r 
                                JOIN users u ON r.user_id = u.id 
                                ORDER BY r.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

<div class="login-container">
    <h2>Reviews</h2>

    <!-- Add Review -->
    <form method="POST" action="">
        <label>Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required>

        <label>Comment:</label>
        <textarea name="comment" rows="3" required></textarea>

        <button type="submit" name="add_review">Add Review</button>
    </form>

    <hr style="margin:20px 0; border-color:#00ff99;">

    <!-- Display Reviews -->
    <?php while($row = mysqli_fetch_assoc($reviews)) { ?>
        <div style="background: rgba(0,255,153,0.1); padding: 10px; border-radius: 10px; margin-bottom: 10px;">
            <strong><?php echo htmlspecialchars($row['name']); ?></strong> 
            <span style="color:#00ff99;">[<?php echo $row['rating']; ?>/5]</span><br>
            <?php echo htmlspecialchars($row['comment']); ?>
            <small style="float:right; color:#ccc;"><?php echo $row['created_at']; ?></small>
        </div>
    <?php } ?>

    <a href="index.php" class="back-btn">Back</a>
</div>
</body>
</html>
