<?php
include 'db.php';
session_start();
if($_SESSION['role'] != 'admin') exit("Access denied");

$id = $_GET['id'];
mysqli_query($conn, "UPDATE cross_matches SET status='approved' WHERE id='$id'");
header("Location: crossmatch_dashboard.php");
