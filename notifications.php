<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Mark notifications as read
if(isset($_GET['read'])){
    $nid = intval($_GET['read']);
    mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id='$nid' AND user_id=".$_SESSION['user_id']);
}

// Fetch notifications
$notifications = mysqli_query($conn, "SELECT * FROM notifications 
                                     WHERE user_id=".$_SESSION['user_id']." 
                                     ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

<div class="login-container">
    <h2>Notifications</h2>

    <?php while($n = mysqli_fetch_assoc($notifications)) { ?>
        <div style="background:<?php echo $n['is_read'] ? 'rgba(255,255,255,0.05)' : 'rgba(0,255,153,0.2)'; ?>; padding:10px; border-radius:10px; margin-bottom:10px;">
            <?php echo htmlspecialchars($n['message']); ?>
            <small style="float:right; color:#ccc;"><?php echo $n['created_at']; ?></small>
            <?php if(!$n['is_read']) { ?>
                <a href="?read=<?php echo $n['id']; ?>" style="color:#fff; text-decoration:none; margin-left:10px;">Mark Read</a>
            <?php } ?>
        </div>
    <?php } ?>

    <a href="index.php" class="back-btn">Back</a>
</div>

</body>
</html>
