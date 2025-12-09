<?php
include 'db.php';
session_start();


if (isset($_POST['action'])) {
    $id = intval($_POST['review_id']);


    if ($_POST['action'] === "delete") {
        mysqli_query($conn, "DELETE FROM reviews WHERE id=$id");
    }


    if ($_POST['action'] === "reject") {
        mysqli_query($conn, "UPDATE reviews SET status='Rejected' WHERE id=$id");
    }


    if ($_POST['action'] === "approve") {
        mysqli_query($conn, "UPDATE reviews SET status='Approved' WHERE id=$id");
    }
}


$total_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM reviews"))['c'];
$avg_rating = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) AS r FROM reviews"))['r'] ?? 0;
$approved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM reviews WHERE status='Approved'"))['c'];
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM reviews WHERE status='Pending'"))['c'];




$reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html>
<head>
<title>Customer Reviews</title>
<link rel="stylesheet" href="review.css">
</head>


<body class="review-body">


<div class="review-wrapper">


    <h2 class="page-title">Customer Reviews</h2>
    <p class="subtitle">Manage and monitor customer feedback</p>


                    <style>
            .review-body {
                background: #0e0e10;
                font-family: Arial, sans-serif;
                color: #fff;
                padding: 30px;
            }


            .review-wrapper {
                max-width: 1100px;
                margin: auto;
            }


            .title {
                font-size: 28px;
                font-weight: 700;
            }
            .subtitle {
                color: #999;
                margin-bottom: 20px;
            }


            .summary-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
                margin-bottom: 30px;
            }


            .summary-card {
                background: #1a1a1d;
                padding: 18px;
                border-radius: 12px;
            }


            .sum-title {
                font-size: 13px;
                color: #bbb;
            }
            .sum-value {
                font-size: 22px;
                font-weight: bold;
            }


            .search-row {
                display: flex;
                gap: 12px;
                margin-bottom: 25px;
            }


            .search-box {
                flex: 1;
                padding: 12px;
                background: #1c1c1f;
                border: 1px solid #333;
                border-radius: 8px;
                color: #ddd;
            }


            .filter-box {
                padding: 12px;
                background: #1c1c1f;
                border: 1px solid #333;
                border-radius: 8px;
                color: #ddd;
            }


            .review-card {
                background: #161618;
                border: 1px solid #232323;
                padding: 20px;
                border-radius: 12px;
                margin-bottom: 18px;
                display: flex;
                gap: 20px;
            }
            .avatar {
                width: 55px;
                height: 55px;
                border-radius: 50%;
                background: #7156f8;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                font-weight: 700;
            }


        
            .review-content {
                flex: 1;
            }


            .review-header {
                font-size: 16px;
            }
            .verified {
                color: #47a8ff;
                font-size: 14px;
            }


            .product-name {
                color: #aaa;
                font-size: 13px;
            }


            .review-text {
                margin-top: 10px;
                color: #ddd;
                line-height: 1.5;
            }


        
            .review-meta {
                margin-top: 10px;
                display: flex;
                gap: 12px;
                align-items: center;
            }


            .helpful {
                color: #bbb;
            }


            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: bold;
            }


            .status-badge.approved {
                background: #0f7d38;
            }
            .status-badge.pending {
                background: #9a6b00;
            }
            .status-badge.rejected {
                background: #851616;
            }


          
            .review-side {
                text-align: right;
            }


            .stars {
                font-size: 18px;
            }


            .date {
                color: #aaa;
                display: block;
                margin: 5px 0 12px;
            }


            /* Buttons */
            .action-btns button {
                display: block;
                width: 100%;
                margin-top: 6px;
                padding: 7px;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                font-size: 13px;
            }


            .view-btn {
                background: #2d2d30;
                color: #fff;
            }
            .reject-btn {
                background: #b86a00;
                color: #fff;
            }
            .delete-btn {
                background: #a62424;
                color: #fff;
            }


</style>


    <div class="summary-grid">
        <div class="summary-card">
            <h3>Total Reviews</h3>
            <p><?php echo $total_reviews; ?></p>
        </div>


        <div class="summary-card">
            <h3>Average Rating</h3>
            <p><?php echo number_format($avg_rating, 1); ?> ⭐</p>
        </div>


        <div class="summary-card">
            <h3>Approved</h3>
            <p><?php echo $approved; ?></p>
        </div>


        <div class="summary-card">
            <h3>Pending</h3>
            <p><?php echo $pending; ?></p>
        </div>
    </div>


    <br>


    <input class="search-box" placeholder="Search reviews...">


    <br><br>


    <?php while ($r = mysqli_fetch_assoc($reviews)): ?>


<div class="review-card">


    <div class="left-section">
        <div class="avatar"><?php echo $initials; ?></div>


        <div class="review-content">
            <strong><?php echo htmlspecialchars($r['full_name']); ?></strong>
            <span class="verified">✔</span>
            <small class="product-name"><br><?php echo htmlspecialchars($r['store_name']); ?></small>


            <p class="review-text"><?php echo htmlspecialchars($r['comment']); ?></p>


            <small class="helpful"><?php echo $r['helpful']; ?> helpful</small>


            <span class="status-badge <?php echo strtolower($r['status']); ?>">
                <?php echo $r['status']; ?>
            </span>
        </div>
    </div>


    <div class="right-section">


        <div class="stars">
            <?php
                echo str_repeat("⭐", $r['rating']) . str_repeat("☆", 5 - $r['rating']);
            ?>
        </div>


        <small class="date"><?php echo $r['created_at']; ?></small>


        <form method="POST" class="action-buttons">
            <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">


            <button type="button" class="view-btn" onclick="openView('<?php echo htmlspecialchars(addslashes($r['comment'])); ?>')">View</button>


            <?php if ($r['status'] !== 'Approved'): ?>
            <button name="action" value="approve" class="approve-btn">Approve</button>
            <?php endif; ?>


            <?php if ($r['status'] !== 'Rejected'): ?>
            <button name="action" value="reject" class="reject-btn">Reject</button>
            <?php endif; ?>


            <button name="action" value="delete" class="delete-btn">Delete</button>
        </form>
    </div>
</div>




        <div class="rating-time">
            <?php
                echo str_repeat("⭐", $r['rating']) . str_repeat("☆", 5 - $r['rating']);
            ?>
            <br>
            <small><?php echo $r['created_at']; ?></small>
        </div>


    </div>


    <?php endwhile; ?>


</div>


<div id="viewModal" class="modal">
    <div class="modal-box">
        <h3>Review Details</h3>
        <p id="modalText"></p>
        <button onclick="closeModal()">Close</button>
    </div>
</div>


<script>
function openView(text) {
    document.getElementById('modalText').innerText = text;
    document.getElementById('viewModal').style.display = "flex";
}
function closeModal() {
    document.getElementById('viewModal').style.display = "none";
}
</script>


</body>
</html>
