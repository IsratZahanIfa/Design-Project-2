<?php
include 'db.php';
session_start();

// Fetch all blogs
$blogs = mysqli_query($conn, "SELECT b.*, u.name as author_name FROM blogs b 
                             JOIN users u ON b.author_id = u.id
                             ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blogs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

<div class="login-container">
    <h2>Blogs</h2>

    <?php while($b = mysqli_fetch_assoc($blogs)) { ?>
        <div style="background: rgba(0,255,153,0.1); padding:15px; border-radius:10px; margin-bottom:15px;">
            <h3 style="margin:0; color:#00ff99;"><?php echo htmlspecialchars($b['title']); ?></h3>
            <small style="color:#ccc;">by <?php echo htmlspecialchars($b['author_name']); ?> | <?php echo $b['created_at']; ?></small>
            <p><?php echo substr(htmlspecialchars($b['content']),0,150).'...'; ?></p>
            <a href="view_blog.php?id=<?php echo $b['id']; ?>" style="color:#00ff99; text-decoration:none;">Read More</a>
        </div>
    <?php } ?>

    <a href="index.php" class="back-btn">Back</a>
</div>

</body>
</html>
