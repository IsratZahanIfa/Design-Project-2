<?php
include 'db.php';
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all blood requests
$sql = "SELECT requests.id, users.name AS seeker_name, requests.blood_group_needed, 
               requests.location, requests.contact, requests.date_needed 
        FROM requests 
        JOIN users ON requests.seeker_id = users.id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Blood Requests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

<div class="admin-container">
    <h2>All Blood Requests</h2>
    <div class="admin-logout">
        Welcome, <?php echo $_SESSION['user_name']; ?> |
        <a href="logout.php">Logout</a>
    </div>

    <table>
        <tr>
            <th>Seeker Name</th>
            <th>Blood Needed</th>
            <th>Location</th>
            <th>Contact</th>
            <th>Date Needed</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['seeker_name']; ?></td>
                <td><?php echo $row['blood_group_needed']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['date_needed']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>





























