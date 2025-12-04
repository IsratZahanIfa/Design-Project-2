<?php
// Start session (optional if you need it)
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "agrotradehub");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if search query is submitted
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $query = trim($_GET['query']);

    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM add_products WHERE name LIKE ?");
    $searchTerm = "%{$query}%";
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "yes"; // Product exists
    } else {
        echo "No products found";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
