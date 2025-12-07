<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Blood Donation Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="style.css" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
					
					
					
					<li><a href="admin.php" class="btn-link">Admin</a></li>
					
					
					
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php" class="btn-link">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-link">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero__grid">
            <div class="hero__copy">
                <h1>
                    <span class="highlight">Blood</span> donors, connected with those in need—anytime, anywhere.
                </h1>
                <p>Join our community and help save lives across Bangladesh.</p>

                <div class="hero__actions">
                    <a href="search.php" class="btn btn-lg btn-primary">Find Donors</a>
                    <a href="request_blood.php" class="btn btn-lg btn-ghost">Request Blood</a>
                </div>

                <ul class="hero__badges">
                    <li>✅ Free & community-driven</li>
                    <li>🚑 Urgent requests highlighted</li>
                    <li>🌐 Nationwide coverage</li>
                </ul>
            </div>

            <div class="hero__card" aria-hidden="true">
                <div class="stat">
                    <div class="stat__num">24/7</div>
                    <div class="stat__label">Availability</div>
                </div>
                <div class="stat">
                    <div class="stat__num">8+</div>
                    <div class="stat__label">Blood Groups</div>
                </div>
                <div class="stat">
                    <div class="stat__num">BD</div>
                    <div class="stat__label">Nationwide</div>
                </div>
            </div>
        </div>
        <div class="hero__wave" aria-hidden="true"></div>
    </section>

    <!-- About Us Section -->
    <section class="about-us">
        <div class="container">
            <h2>About Us</h2>
            <p>We are more than just a platform—this is a movement driven by passion, empathy, and the desire to make the world a better place. Our mission is simple: connect blood donors with those in urgent need of help. We believe that when people unite, incredible things happen.</p>
            <div class="about-us__grid">
                <div class="about-us__card">
                    <h3><i class="fas fa-heartbeat" aria-hidden="true" style="color:var(--brand);margin-right:8px;"></i>Saving Lives</h3>
                    <p>Every single donation can save up to three lives. Your blood could be the lifeline someone is desperately waiting for.</p>
                </div>
                <div class="about-us__card">
                    <h3><i class="fas fa-medal" aria-hidden="true" style="color:var(--brand);margin-right:8px;"></i>You Are the Hero</h3>
                    <p>We believe that young people like you have the power to change the world. By donating blood, you’re making a difference in the lives of others—whether they are in a hospital, recovering from an accident, or battling a disease.</p>
                </div>
                <div class="about-us__card">
                    <h3><i class="fas fa-bolt" aria-hidden="true" style="color:var(--brand);margin-right:8px;"></i>Easy & Impactful</h3>
                    <p>Joining our community is simple. With just a few clicks, you can register, request blood, or find a nearby donor when needed. Make an impact with minimal effort!</p>
                </div>
            </div>
            <div class="about-us__cta">
                <p>So, why wait? Join us today and become a part of this life-saving community. Be a hero in your own way!</p>
                <a href="register.php" class="btn btn-lg btn-primary">Join the Movement</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="services__grid">
                <div class="service__item">
                    <i class="fas fa-heartbeat service__icon"></i>
                    <h3>Save a Life</h3>
                </div>
                <div class="service__item">
                    <i class="fas fa-tint service__icon"></i>
                    <h3>Donate Blood</h3>
                </div>
                <div class="service__item">
                    <i class="fas fa-donate service__icon"></i>
                    <h3>Donate Money</h3>
                </div>
                <div class="service__item">
                    <i class="fas fa-campground service__icon"></i>
                    <h3>Arrange Camp</h3>
                </div>
            </div>
        </div>
    </section>

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
