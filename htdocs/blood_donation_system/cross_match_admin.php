<?php
include 'db.php';
session_start();
if($_SESSION['role'] != 'admin') exit("Access denied");

$sql = "SELECT cm.id, u.name AS donor_name, r.blood_group_needed, r.rh_needed, r.seeker_id, cm.compatibility, cm.status
        FROM cross_matches cm
        JOIN donors d ON cm.donor_id = d.id
        JOIN users u ON d.user_id = u.id
        JOIN requests r ON cm.request_id = r.id
        ORDER BY cm.date_checked DESC";
$res = mysqli_query($conn,$sql);
?>
<table>
<tr><th>Donor</th><th>Seeker ID</th><th>Blood Needed</th><th>Compatibility</th><th>Status</th><th>Action</th></tr>
<?php while($row = mysqli_fetch_assoc($res)): ?>
<tr>
    <td><?= $row['donor_name'] ?></td>
    <td><?= $row['seeker_id'] ?></td>
    <td><?= $row['blood_group_needed']." ".$row['rh_needed'] ?></td>
    <td><?= $row['compatibility'] ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <?php if($row['compatibility']=='compatible' && $row['status']=='pending'): ?>
            <a href="approve_crossmatch.php?id=<?= $row['id'] ?>">Approve</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
