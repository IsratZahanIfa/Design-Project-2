<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$server = "localhost";  
$user   = "root";      
$pass   = "";          
$dbname = "agrotradehub"; 

try {
    $conn = new mysqli($server, $user, $pass, $dbname);
    $conn->set_charset("utf8");
} catch (Exception $e) {
    echo "<h3 style='color:red;'>Database Connection Failed!</h3>";
    echo $e->getMessage();
    exit;
}
?>
