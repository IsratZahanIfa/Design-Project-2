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
    <style>
        body.review-body { background: #0e0e10; font-family: Arial, sans-serif; color: #fff; padding: 30px; }
        .review-wrapper { max-width: 1100px; margin: auto; }
        .page-title { font-size: 28px; font-weight: 700; }
        .subtitle { color: #999; margin-bottom: 20px; }
        .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px; }
        .summary-card { background: #1a1a1d; padding: 18px; border-radius: 12px; text-align: center; }
        .summary-card h3 { font-size: 13px; color: #bbb; margin-bottom: 5px; }
        .summary-card p { font-size: 22px; font-weight: bold; margin: 0; }
        .search-box { width: 100%; padding: 12px; background: #1c1c1f; border: 1px solid #333; border-radius: 8px; color: #ddd; margin-bottom: 25px; }
        .review-card { background: #161618; border: 1px solid #232323; padding: 20px; border-radius: 12px; margin-bottom: 18px; display: flex; justify-content: space-between; gap: 20px; }
        .avatar { width: 55px; height: 55px; border-radius: 50%; background: #7156f8; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; }
        .review-content { flex: 1; }
        .verified { color: #47a8ff; font-size: 14px; margin-left: 5px; }
        .product-name { color: #aaa; font-size: 13px; }
        .review-text { margin-top: 10px; color: #ddd; line-height: 1.5; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-badge.approved { background: #0f7d38; }
        .status-badge.pending { background: #9a6b00; }
        .status-badge.rejected { background: #851616; }
        .right-section { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 8px; }
        .stars { font-size: 18px; }
        .date { color: #aaa; font-size: 12px; }
        .action-buttons button { display: block; width: 100%; margin-top: 6px; padding: 7px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; }
        .view-btn { background: #2d2d30; color: #fff; }
        .approve-btn { background: #0f7d38; color: #fff; }
        .reject-btn { background: #a62424; color: #fff; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background: #1a1a1d; padding: 20px; border-radius: 12px; width: 400px; color: #fff; }
        .modal-box button { margin-top: 15px; width: 100%; padding: 10px; background: #7156f8; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body class="review-body">
<div class="review-wrapper">
    <h2 class="page-title">Customer Reviews</h2>
    <p class="subtitle">Manage and monitor customer feedback</p>

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

    <input class="search-box" placeholder="Search reviews...">

    <?php while ($r = mysqli_fetch_assoc($reviews)): ?>
        <?php
        $initials = '';
        if (!empty($r['name'])) {
            $parts = explode(' ', $r['name']);
            foreach ($parts as $p) $initials .= strtoupper($p[0]);
            $initials = substr($initials, 0, 2);
        }

        $name = $r['name'] ?? 'Unknown';
        $store_name = $r['store_name'] ?? '';
        $product_name = $r['product_name'] ?? '';
        $review_text = $r['review'] ?? '';
        $status = $r['status'] ?? 'Pending';
        $rating = intval($r['rating'] ?? 0);
        $created_at = $r['created_at'] ?? '';
        $review_id = $r['id'] ?? 0;
        ?>

        <div class="review-card">
            <div class="left-section">
                <div class="avatar"><?php echo $initials; ?></div>
                <div class="review-content">
                    <strong><?php echo htmlspecialchars($name); ?></strong>
                    <span class="verified">✔</span>
                    <small class="product-name"><br><?php echo htmlspecialchars($store_name . " - " . $product_name); ?></small>
                    <p class="review-text"><?php echo htmlspecialchars($review_text); ?></p>
                    <span class="status-badge <?php echo strtolower($status); ?>"><?php echo $status; ?></span>
                </div>
            </div>

            <div class="right-section">
                <div class="stars"><?php echo str_repeat("⭐", $rating) . str_repeat("☆", 5 - $rating); ?></div>
                <small class="date"><?php echo $created_at; ?></small>

                <form method="POST" class="action-buttons">
                    <input type="hidden" name="review_id" value="<?php echo $review_id; ?>">
                    <button type="button" class="view-btn" onclick="openView('<?php echo htmlspecialchars(addslashes($review_text)); ?>')">View</button>
                    <?php if ($status !== 'Approved'): ?>
                        <button name="action" value="approve" class="approve-btn">Approve</button>
                    <?php endif; ?>
                    <?php if ($status !== 'Rejected'): ?>
                        <button name="action" value="reject" class="reject-btn">Reject</button>
                </form>
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
