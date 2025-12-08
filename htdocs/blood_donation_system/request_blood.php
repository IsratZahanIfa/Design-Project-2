<?php
session_start();
include("db.php");

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Save redirect URL so user comes back here after login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}

// ✅ Only seekers can request blood
if ($_SESSION['role'] != 'seeker') {
    echo "⚠️ Only seekers can request blood!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seeker_id = $_SESSION['user_id']; // ✅ Corrected
    $blood_group_needed = mysqli_real_escape_string($conn, $_POST['blood_group_needed']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $date_needed = mysqli_real_escape_string($conn, $_POST['date_needed']);

    // ✅ Insert into requests table
    $sql = "INSERT INTO requests (seeker_id, blood_group_needed, location, contact, date_needed) 
            VALUES ('$seeker_id', '$blood_group_needed', '$location', '$contact', '$date_needed')";

    if (mysqli_query($conn, $sql)) {
        echo "<p class='success-message'>✅ Blood request submitted successfully!</p>";
    } else {
        echo "<p class='error-message'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Request Blood</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Link to Poppins font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
</head>
<body>

    <!-- Top bar -->
    <div class="topbar">
        <div class="container topbar__inner">
            <div class="topbar__contact">
                <span>📞 <a href="tel:01625524255">01625-524255</a></span>
                <span class="divider">|</span>
                <span>✉️ <a href="mailto:support@blooddonation.com">support@blooddonation.com</a></span>
            </div>
            <div class="topbar__cta">
                <a class="btn btn-xxs btn-light" href="register.php" aria-label="Become a donor">Become a Donor</a>
            </div>
        </div>
    </div>

    <!-- Header / Navigation -->
    <header class="site-header">
        <div class="container header__inner">
            <a href="index.php" class="brand" aria-label="Home">
                <span class="brand__mark">🩸</span>
                <span class="brand__text">Blood Donation</span>
            </a>
            <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="site-nav">
                <span class="nav-toggle__bar"></span>
                <span class="nav-toggle__bar"></span>
                <span class="nav-toggle__bar"></span>
            </button>
            <nav id="site-nav" class="nav">
                <ul>
                    <li><a href="search.php">Search Donors</a></li>
                    <li><a href="request_blood.php">Add Blood Request</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="view_requests.php">View Requests</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php" class="btn-link">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-link">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Request Blood Page -->
    <div class="request-blood-page">

        <!-- Centered Title in a red box -->
        <div class="request-header">
            <h2>REQUEST BLOOD</h2>
        </div>

        <!-- Instruction Text -->
        <p class="instruction-text">Fill in the form below to request blood</p>

        <!-- Request Form -->
        <form method="POST" action="" class="search-form">
            <div class="form-row">
                <label for="blood_group_needed">Blood Group Needed</label>
                <input type="text" id="blood_group_needed" name="blood_group_needed" placeholder="e.g. A+, O-" required>
            </div>
            
            <div class="form-row">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="Enter city/district" required>
            </div>
            
            <div class="form-row">
                <label for="contact">Contact</label>
                <input type="text" id="contact" name="contact" placeholder="Enter your contact number" required>
            </div>
            
            <div class="form-row">
                <label for="date_needed">Date Needed</label>
                <input type="date" id="date_needed" name="date_needed" required>
            </div>

            <button type="submit" class="btn btn-submit">Submit Request</button>
        </form>

        <!-- Success or Error Messages -->
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
    </div>

    <!-- Footer Section -->
    <footer class="site-footer">
        <div class="container footer__inner">
            <div class="footer__social">
                <p>Follow us on social media platforms.</p>
                <div class="social-icons">
                    <a href="twitter-link"><i class="fab fa-twitter"></i></a>
                    <a href="whatsapp-link"><i class="fab fa-whatsapp"></i></a>
                    <a href="instagram-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer__links">
                <div class="footer__column">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="become-donor.php">Become Donor</a></li>
                        <li><a href="request-blood.php">Request Blood</a></li>
                        <li><a href="donate-money.php">Donate Money</a></li>
                    </ul>
                </div>
                <div class="footer__column">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="about-us.php">About Us</a></li>
                        <li><a href="become-member.php">Become A Member</a></li>
                        <li><a href="events.php">Events</a></li>
                    </ul>
                </div>
                <div class="footer__column">
                    <h4>Contacts</h4>
                    <ul>
                        <li>ULAB, Dhaka</li>
                        <li>+88 123 456 789</li>
                        <li>contact@ulab.com</li>
                    </ul>
                </div>
            </div>
            <p>&copy; 2025 ULAB Blood Donor Society. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile nav toggle (no backend changes)
        const toggle = document.querySelector('.nav-toggle');
        const nav = document.getElementById('site-nav');

        if (toggle && nav) {
            toggle.addEventListener('click', () => {
                const open = nav.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }
    </script>
</body>
</html>
