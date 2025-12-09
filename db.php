<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = getenv("b.fr-paril.bengt.wasmernet.com");
$port = getenv("10272");
$user = getenv("88377ea378be800013b448d66296");
$pass = getenv("06938837-7ea3-7a9e-8000-805880cedec7");
$db   = getenv("agrotradehub");

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>