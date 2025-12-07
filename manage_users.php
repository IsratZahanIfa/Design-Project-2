<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM sellers WHERE user_id=$id");
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: manage_users.php");
    exit;
}


$users = mysqli_query($conn, "SELECT * FROM users");

$total_users   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users"))['c'];
$total_sellers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE role='seller'"))['c'];
$total_customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE role='customer'"))['c'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
       
        * { 
       margin:0; 
       padding:0; 
       box-sizing:border-box; 
       font-family: Arial, sans-serif; 
    }

        body { 
            background:#121212; 
            color:#fff; 
            padding:18px; 
        }

        h1 { 
            font-size:22px; 
            margin-bottom:20px; 
        }

        .top-box-container { 
            display:flex; 
            gap:20px; 
            flex-wrap:wrap; 
            margin-bottom:20px; 
        }

        .box { 
            background:#1f1f1f; 
            padding:20px; 
            border-radius:12px; 
            flex:1; 
            min-width:150px; 
        }

        .box-title { 
            font-size:14px; 
            color:#aaa; 
            margin-bottom:8px; 
        }

        .box-number { 
            font-size:24px; 
            font-weight:bold; 
            color:#00ffcc; }

        .search-bar { 
            display: flex; 
            gap: 10px; 
            margin-bottom: 20px; 
            flex-wrap: wrap; 
        }

        .search-bar input { 
            flex:1; 
            padding: 10px 12px; 
            border-radius: 8px; 
            border: none; 
            background: #1f1f1f; 
            color: #fff; }

        .filter-btns { 
            display:flex; 
            gap:10px;
         }

        .filter-btns button { 
            padding: 10px 16px; 
            border: none; 
            border-radius: 8px;             
            background: #2a2a2a; 
            color: #fff; 
            cursor: pointer; 
        }

        .filter-btns button:hover { 
            background: #00ffcc; 
            color: #000; 
        }

        table { 
            width:100%; 
            border-collapse:collapse; 
        }

        th, td { 
            padding:12px; 
            text-align:left; 
            border-bottom:1px solid #333;
         }

        th {
             background: #1f1f1f; 
             color: #aaa; 
        }
        
        tr:hover { 
                background: #1a1a1a; 
            }
        
        .action-btn { 
            padding:6px 12px; 
            border-radius:5px; 
            font-size:13px; 
            text-decoration:none; 
            margin-right:5px;
         }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #00ffcc;
        }
    </style>

    <script>
        function filterRole(role) {
            const rows = document.querySelectorAll(".user-row");
            rows.forEach(r => {
                if (role === "all") r.style.display = "table-row";
                else r.style.display = r.dataset.role === role ? "table-row" : "none";
            });
        }

        function searchUsers() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll(".user-row");
            rows.forEach(r => {
                const text = r.textContent.toLowerCase();
                r.style.display = text.includes(input) ? "table-row" : "none";
            });
        }
    </script>
</head>
<body>

<h1>User Management Dashboard</h1>
<div class="top-box-container">
    <div class="box">
        <div class="box-title">Total Users</div>
        <div class="box-number"><?= $total_users ?></div>
    </div>
    <div class="box">
        <div class="box-title">Sellers</div>
        <div class="box-number"><?= $total_sellers ?></div>
    </div>
    <div class="box">
        <div class="box-title">Customers</div>
        <div class="box-number"><?= $total_customers ?></div>
    </div>
</div>

<div class="search-bar">
    <input type="text" id="searchInput" onkeyup="searchUsers()" placeholder="Search by name or id...">
    <div class="filter-btns">
        <button onclick="filterRole('all')">All</button>
        <button onclick="filterRole('seller')">Seller</button>
        <button onclick="filterRole('customer')">Customer</button>
    </div>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while ($u = mysqli_fetch_assoc($users)) { ?>
    <tr class="user-row" data-role="<?= $u['role'] ?>">
        <td><?= $u['id'] ?></td>
        <td><?= $u['name'] ?></td>
        <td><?= $u['email'] ?></td>
        <td><?= $u['contact'] ?></td>
        <td><?= $u['role'] ?></td>
        <td>
            <a class="action-btn delete" onclick="return confirm('Block this user?')" href="manage_users.php?delete=<?= $u['id'] ?>">Block</a>
        </td>
    </tr>
    <?php } ?>
</table>

        <a class="back" href="admin_dashboard.php">← Back to Dashboard</a>

</body>
</html>
