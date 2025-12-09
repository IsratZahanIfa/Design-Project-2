<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT id, name, email, password, contact, created_at, role FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();


$fullName = $user['name'] ?? "";
$nameParts = explode(" ", $fullName, 2);
$first_name = $nameParts[0] ?? "";
$last_name  = $nameParts[1] ?? "";
$email      = $user['email'] ?? "";
$contact    = $user['contact'] ?? "";
$role       = $user['role'] ?? "";
$member_since = $user['created_at'] ?? "";


$success = "";
$errorMsg = "";


if (isset($_POST['update_info'])) {
    $newFirst = trim($_POST['first_name']);
    $newLast  = trim($_POST['last_name']);
    $newEmail = trim($_POST['email']);
    $newContact = trim($_POST['contact']);


    if ($newFirst == "" || $newLast == "" || $newEmail == "" || $newContact == "") {
        $errorMsg = "All fields are required!";
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Invalid email format!";
    } else {
        $updatedName = $newFirst . " " . $newLast;
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, contact=? WHERE id=?");
        $stmt->bind_param("sssi", $updatedName, $newEmail, $newContact, $user_id);


        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
            $first_name = $newFirst;
            $last_name  = $newLast;
            $email      = $newEmail;
            $contact    = $newContact;
        } else {
            $errorMsg = "Failed to update information.";
        }
    }
}




if (isset($_POST['update_password'])) {
    $oldPass = trim($_POST['old_password']);
    $newPass = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);


    if (empty($oldPass) || empty($newPass) || empty($confirm)) {
        $errorMsg = "All password fields are required!";
    } elseif ($newPass !== $confirm) {
        $errorMsg = "New passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $userPass = $stmt->get_result()->fetch_assoc()['password'];


        if (!password_verify($oldPass, $userPass)) {
            $errorMsg = "Old password is incorrect!";
        } else {
            $hashed = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
            $stmt->bind_param("si", $hashed, $user_id);


            if ($stmt->execute()) {
                $success = "Password updated successfully!";
            } else {
                $errorMsg = "Failed to update password.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Profile Settings</title>
<style>
body{background:#0f0f0f;color:white;font-family:Arial;padding:30px;}
.container{display:flex;gap:25px;}
.sidebar{width:250px;background:#1a1a1a;padding:20px;border-radius:12px;}
.sidebar a{display:block;padding:12px;background:#222;color:white;border-radius:8px;text-decoration:none;margin-bottom:10px;cursor:pointer;}
.sidebar a.active{background:white;color:black;}
.profile-card{background:#1a1a1a;padding:20px;margin-top:20px;border-radius:12px;text-align:center;}
.profile-card .avatar{width:70px;height:70px;border-radius:50%;background:#4b4bff;font-size:24px;display:flex;align-items:center;justify-content:center;margin:auto;}
.content{flex:1;display:flex;flex-direction:column;gap:30px;}
.box{background:#1a1a1a;padding:25px;border-radius:12px;display:none;}
.box.active{display:block;}
textarea,input{width:100%;background:#121212;border:1px solid #333;padding:12px;border-radius:8px;color:white;margin-bottom:15px;}
.save-btn{background:white;color:black;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-weight:bold;text-align:center;display:inline-block;}
.success{background:#113d1f;padding:10px;border-radius:8px;}
.error{background:#5c1a1a;padding:10px;border-radius:8px;}
</style>
</head>
<body>


<div class="container">


    <div class="sidebar">
        <a class="active" onclick="showTab('personal')">Personal Info</a>
        <a onclick="showTab('password')">Password & Security</a>
        <a href="customer_dashboard.php" class="save-btn">Back to Dashboard</a>


        <div class="profile-card">
            <div class="avatar"><?= strtoupper($first_name[0] . $last_name[0]) ?></div>
            <h4><?= $first_name . " " . $last_name ?></h4>
            <p><?= $email ?></p>
            <p>Member Since: <?= substr($member_since,0,10) ?></p>
            <p>Role: <?= ucfirst($role) ?></p>
        </div>
    </div>


    <div class="content">
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
            <?php endif; ?>
        <?php if ($errorMsg): ?>
            <div class="error"><?= $errorMsg ?></div>
            <?php endif; ?>


        <div class="box active" id="personal">
            <h3>Personal Information</h3>
            <form method="POST">
                <label>First Name *</label>
                <input type="text" name="first_name" value="<?= $first_name ?>" required>
                <label>Last Name *</label>
                <input type="text" name="last_name" value="<?= $last_name ?>" required>
                <label>Email *</label>
                <input type="email" name="email" value="<?= $email ?>" required>
                <label>Contact *</label>
                <input type="text" name="contact" value="<?= $contact ?>" required>
                <button class="save-btn" name="update_info">Save Information</button>
            </form>
        </div>


        <div class="box" id="password">
            <h3>Password & Security</h3>
            <form method="POST">
                <label>Old Password *</label>
                <input type="password" name="old_password" required>
                <label>New Password *</label>
                <input type="password" name="new_password" required>
                <label>Confirm New Password *</label>
                <input type="password" name="confirm_password" required>
                <button class="save-btn" name="update_password">Change Password</button>
            </form>
        </div>
    </div>
</div>


<script>
function showTab(tabId){
    document.querySelectorAll('.box').forEach(box => box.classList.remove('active'));
    document.querySelectorAll('.sidebar a').forEach(link => link.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    event.target.classList.add('active');
}
</script>


</body>
</html>
