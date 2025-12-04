<?php
include 'db.php';
session_start();

$blood_group = $_GET['blood_group'] ?? '';
$rh = $_GET['rh'] ?? '';
$location = $_GET['location'] ?? '';

$sql = "SELECT d.*, u.name FROM donors d JOIN users u ON d.user_id = u.id WHERE 1=1";
$params = [];
$types = '';

if($blood_group !== '') {
    $sql .= " AND d.blood_group LIKE ?";
    $types .= 's';
    $params[] = "%$blood_group%";
}
if($rh !== '') {
    $sql .= " AND d.rh_factor = ?";
    $types .= 's';
    $params[] = $rh;
}
if($location !== '') {
    $sql .= " AND d.location LIKE ?";
    $types .= 's';
    $params[] = "%$location%";
}

$stmt = mysqli_prepare($conn, $sql);
if($types !== '') mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$donors = [];
while($row = mysqli_fetch_assoc($result)){
    $donors[] = $row;
}

// Filter using compatibility function
$compatible_donors = array_filter($donors, function($d) use($blood_group,$rh){
    return is_compatible($d['blood_group'], $d['rh_factor'], $blood_group, $rh);
});
?>
