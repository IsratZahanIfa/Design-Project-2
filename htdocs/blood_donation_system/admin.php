<?php
include 'db.php';
session_start();

// If admin already logged in → show dashboard
if (isset($_SESSION['admin'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="admin-body">

    <div class="admin-container">
        <h2 style="text-align:center; color:blue;">Admin Dashboard</h2>
        <div class="admin-logout" style="text-align:right; margin-bottom:20px;">
            Welcome, <?php echo $_SESSION['admin']; ?> | 
            <a href="logout.php" style="color:red; font-weight:bold;">Logout</a>
        </div>

        <!-- Show all donors -->
        <h2 style="text-align:center; color:blue;">All Donors</h2>
        <table border="1" cellpadding="8" cellspacing="0" style="width:100%; text-align:center;">
            <tr style="background:#b30000; color:white;">
                <th>Name</th>
                <th>Blood Group</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>

            <?php
            // ✅ Query without last_donation_date
            $sql = "SELECT donors.id, users.name, donors.blood_group, donors.location, donors.contact 
                    FROM donors 
                    JOIN users ON donors.user_id = users.id";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['blood_group']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['contact']}</td>
                    <td>
                        <a href='delete_donor.php?id={$row['id']}' 
                           onclick=\"return confirm('Are you sure you want to delete this donor?')\">
                           ❌ Delete
                        </a>
                    </td>
                </tr>";
            }
            ?>
        </table>

        <!-- Show all requests -->
        <h2 style="text-align:center; color:blue; margin-top:40px;">All Blood Requests</h2>
        <table border="1" cellpadding="8" cellspacing="0" style="width:100%; text-align:center;">
            <tr style="background:#b30000; color:white;">
                <th>Seeker Name</th>
                <th>Blood Needed</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Date Needed</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT requests.id, users.name AS seeker_name, requests.blood_group_needed, 
                           requests.location, requests.contact, requests.date_needed 
                    FROM requests 
                    JOIN users ON requests.seeker_id = users.id";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['seeker_name']}</td>
                    <td>{$row['blood_group_needed']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['contact']}</td>
                    <td>{$row['date_needed']}</td>
                    <td>
                        <a href='delete_request.php?id={$row['id']}' 
                           onclick=\"return confirm('Are you sure you want to delete this request?')\">
                           ❌ Delete
                        </a>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>
    </body>
    </html>
    <?php
    exit;
}

// If login form submitted → check credentials
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password=MD5('$password')");
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">

<div class="admin-container">
    <h2 style="text-align:center;">Admin Login</h2>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
    <p style="color:red; text-align:center;">
        <?php if (isset($error)) echo $error; ?>
    </p>
</div>

</body>
</html>
