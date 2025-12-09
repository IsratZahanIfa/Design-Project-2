<?php
session_start();
include 'db.php';


if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}


if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE orders SET status='approved' WHERE id=$id");
    exit(header("Location: manage_orders.php"));
}


if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    mysqli_query($conn, "UPDATE orders SET status='rejected' WHERE id=$id");
    exit(header("Location: manage_orders.php"));
}


$total_orders   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders"))['c'];
$pending_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders WHERE status='pending'"))['c'];
$approved_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders WHERE status='approved'"))['c'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price * quantity) AS rev FROM orders WHERE status='approved'"))['rev'];
$total_revenue = $total_revenue ? number_format($total_revenue, 2) : "0.00";


$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Orders</title>


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>
    body{
        margin:0;
        padding:0;
        font-family:'Poppins',sans-serif;
        background:#0e0e0e;
        color:#fff;
    }


    .container{
        width:95%;
        margin:20px auto;
    }


    h2{
        font-weight:600;
        margin-bottom:5px;
    }


    .subtitle{
        color:#bbb;
        margin-bottom:25px;
    }


    .stats{
        display:flex;
        gap:20px;
        margin-bottom:30px;
    }


    .card{
        flex:1;
        background:#1a1a1a;
        padding:25px;
        border-radius:12px;
        border:1px solid #2a2a2a;
    }


    .filters{
        background:#1a1a1a;
        padding:20px;
        border-radius:12px;
        border:1px solid #2a2a2a;
        margin-bottom:20px;
    }


    .filters input{
        width:40%;
        padding:10px;
        border-radius:8px;
        border:none;
        background:#2a2a2a;
        color:white;
    }


    table{
        width:100%;
        border-collapse:collapse;
        margin-top:15px;
    }


    th,td{
        padding:15px;
        border-bottom:1px solid #2a2a2a;
    }


    .status{
        padding:6px 12px;
        border-radius:20px;
    }
    .pending{ background:#5f4b00; color:#ffce3b; }
    .approved{ background:#003f1a; color:#38e27d; }
    .rejected{ background:#4a0000; color:#ff6b6b; }


    .btn{
        padding:7px 14px;
        border-radius:6px;
        cursor:pointer;
        font-size:13px;
        border:none;
        text-decoration:none;
        margin-right:5px;
    }


    .approve{ background:#006e2f; color:white; }
    .reject{ background:#8b0000; color:white; }
</style>


<script>
function searchProduct() {
    let keyword = document.getElementById("searchBox").value;


    let xhr = new XMLHttpRequest();
    xhr.open("GET", "search_orders.php?key=" + keyword, true);


    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById("orderTableBody").innerHTML = this.responseText;
        }
    };


    xhr.send();
}
</script>


</head>


<body>
<div class="container">


    <h2>Manage Orders</h2>
    <div class="subtitle">Admin panel to manage all customer orders</div>


    <div class="stats">
        <div class="card"><small>Total Orders</small><h3><?= $total_orders ?></h3></div>
        <div class="card"><small>Pending Approval</small><h3><?= $pending_orders ?></h3></div>
        <div class="card"><small>Approved</small><h3><?= $approved_orders ?></h3></div>
        <div class="card"><small>Total Revenue</small><h3>$<?= $total_revenue ?></h3></div>
    </div>


    <div class="filters">
        <input type="text" id="searchBox" onkeyup="searchProduct()" placeholder="Search product name...">
    </div>


    <table>
        <thead>
            <tr>
                <th>PRODUCT NAME</th>
                <th>PRICE</th>
                <th>QUANTITY</th>
                <th>STORE NAME</th>
                <th>ORDER DATE</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
            </tr>
        </thead>


        <tbody id="orderTableBody">
        <?php while ($o = mysqli_fetch_assoc($orders)) { ?>
            <tr>
                <td><strong><?= htmlspecialchars($o['product_name']) ?></strong></td>
                <td>$<?= number_format($o['price'],2) ?></td>
                <td><?= $o['quantity'] ?></td>
                <td><?= htmlspecialchars($o['store_name']) ?></td>
                <td><?= date("M d, Y", strtotime($o['order_date'])) ?></td>


                <td>
                    <span class="status <?= $o['status'] ?>">
                        <?= strtoupper($o['status']) ?>
                    </span>
                </td>


                <td>
                    <?php if ($o['status']=='pending'){ ?>
                        <a href="?approve=<?= $o['id'] ?>" class="btn approve">Approve</a>
                        <a href="?reject=<?= $o['id'] ?>" class="btn reject">Reject</a>
                    <?php } else { ?>
                        <span style="color:#aaa;">No Action</span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>


</div>
</body>
</html>
