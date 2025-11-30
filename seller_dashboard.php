<?php
// seller_dashboard.php
session_start();
include 'db.php'; // make sure this path is correct and $conn is defined

// -----------------------------
// 1) Session & role checks
// -----------------------------
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$uid = intval($_SESSION['user_id']);
$session_email = $_SESSION['email'] ?? null;

// If we don't have a session email, force logout (or redirect to login)
if (!$session_email) {
    header("Location: logout.php");
    exit();
}

// -----------------------------
// 2) Fetch seller from DB (prepared statement)
// -----------------------------
$seller = null;

$sql = "SELECT name, email, contact, created_at FROM sellers WHERE user_id = ? LIMIT 1";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res && mysqli_num_rows($res) === 1) {
        $seller = mysqli_fetch_assoc($res);
    }
    mysqli_stmt_close($stmt);
} else {
    // Query prepare failed -> optional debug (remove in production)
    // die("DB prepare error: " . mysqli_error($conn));
    header("Location: logout.php");
    exit();
}

// If no seller record, redirect (not approved / not registered)
if (!$seller) {
    // change to seller_register.php or an "awaiting approval" page if you have one
    header("Location: seller_register.php");
    exit();
}

// Optional: ensure session email exactly matches seller table email
if (!isset($seller['email']) || $seller['email'] !== $session_email) {
    // Email mismatch — treat as unauthorized
    header("Location: logout.php");
    exit();
}

// -----------------------------
// 3) Helper to safely print HTML
// -----------------------------
function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// Provide safe defaults so the template never tries to access undefined indexes
$seller_name    = $seller['name']    ?? 'Seller';
$seller_email   = $seller['email']   ?? 'Not provided';
$seller_contact = $seller['contact'] ?? 'Not provided';
$seller_joined  = !empty($seller['created_at']) ? date("F j, Y", strtotime($seller['created_at'])) : 'Not Recorded';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard | AgroTradeHub</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{ --accent:#4f46e5; --card-bg:#f0f4ff; --card-hover:#003f19; }
        *{ box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #f7f9fc;
            color: #0b1220;
            min-height: 100vh;
        }

        .page {
            max-width: 1100px;
            margin: 36px auto;
            padding: 20px;
            position: relative;
        }

        .header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            margin-bottom:18px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: rgba(255,255,255,0.85);
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(3,10,34,0.06);
        }

        .profile-card img {
            width:72px;
            height:72px;
            border-radius:50%;
            object-fit:cover;
            background: #e6eefc;
            border: 2px solid rgba(0,0,0,0.04);
        }

        .profile-info h3 { margin:0 0 4px 0; font-size:18px; }
        .profile-info p { margin: 2px 0; color: #374151; font-size:14px; }

        .logout-btn {
            padding: 8px 14px;
            background: var(--accent);
            border: none;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display:flex;
            align-items:center;
            gap:8px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 18px;
            margin-top: 20px;
        }

        .dash-box {
            background: var(--card-bg);
            text-align: center;
            padding: 22px 14px;
            border-radius: 12px;
            color: #060606;
            text-decoration: none;
            transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
            box-shadow: 0 6px 18px rgba(3,10,34,0.04);
        }
        .dash-box:hover {
            transform: translateY(-6px);
            background: var(--card-hover);
            color: #fff;
            box-shadow: 0 12px 30px rgba(0,0,0,0.14);
        }
        .dash-box i { font-size:28px; display:block; margin-bottom:10px; }
        .dash-box h3 { margin:0 0 6px 0; font-size:16px; }
        .dash-box p { margin:0; font-size:13px; opacity:0.95; }

        @media (max-width:520px){
            .header{ flex-direction:column; align-items:flex-start; gap:12px; }
        }
    </style>
</head>
<body>
<div class="page">

    <div class="header">
        <div class="profile-card" role="region" aria-label="Seller profile">
            <img src="https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg" alt="Profile image">
            <div class="profile-info">
                <h3><?php echo h($seller_name); ?></h3>
                <p>Email: <?php echo h($seller_email); ?></p>
                <p>Contact: <?php echo h($seller_contact); ?></p>
                <p style="font-size:13px;color:#6b7280;">Joined: <?php echo h($seller_joined); ?></p>
            </div>
        </div>

        <div>
            <button class="logout-btn" onclick="window.location.href='logout.php'">
                <i class="fa fa-sign-out-alt" aria-hidden="true"></i> Logout
            </button>
        </div>
    </div>

    <div class="dashboard-grid">
        <a href="add_product.php" class="dash-box">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
            <h3>Add Product</h3>
            <p>নতুন কৃষি আইটেম আপলোড</p>
        </a>

        <a href="manage_products.php" class="dash-box">
            <i class="fa fa-edit" aria-hidden="true"></i>
            <h3>Manage Products</h3>
            <p>পণ্য অনুসন্ধান, আপডেট বা অপসারণ</p>
        </a>

        <a href="order_information.php" class="dash-box">
            <i class="fa fa-truck" aria-hidden="true"></i>
            <h3>Order Information</h3>
            <p>অর্ডার দেখুন</p>
        </a>

        <a href="notifications.php" class="dash-box">
            <i class="fa fa-bell" aria-hidden="true"></i>
            <h3>Notifications</h3>
            <p>নতুন সতর্কতা এবং বার্তা দেখুন</p>
        </a>
    </div>

</div>
</body>
</html>
