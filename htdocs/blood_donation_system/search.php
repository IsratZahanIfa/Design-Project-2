<?php
session_start();
include 'db.php';

// ---- Filters (GET so the URL is shareable) ----
$blood_group = isset($_GET['blood_group']) ? trim($_GET['blood_group']) : '';
$location    = isset($_GET['location']) ? trim($_GET['location']) : '';
$donor_name  = isset($_GET['donor_name']) ? trim($_GET['donor_name']) : '';

// ---- Query donors (JOIN users + donors) ----
$sql = "SELECT u.name, d.blood_group, d.location, d.contact
        FROM donors d
        JOIN users u ON u.id = d.user_id
        WHERE 1=1";

$types = '';
$params = [];

if ($blood_group !== '') {
  $sql .= " AND d.blood_group LIKE ?";
  $types .= 's';
  $params[] = '%' . $blood_group . '%';
}
if ($location !== '') {
  $sql .= " AND d.location LIKE ?";
  $types .= 's';
  $params[] = '%' . $location . '%';
}
if ($donor_name !== '') {
  $sql .= " AND u.name LIKE ?";
  $types .= 's';
  $params[] = '%' . $donor_name . '%';
}

$sql .= " ORDER BY u.name ASC";
$stmt = mysqli_prepare($conn, $sql);
if ($types !== '') {
  mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$donors = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $donors[] = $row;
  }
}
$total = count($donors);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Search Blood Donors</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

  <!-- Styles -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>
    .search-page .container.results-container { max-width: 1150px; }
    .donor-cards{
      width:100%;
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap:24px;
      margin-top:16px;
    }
    @media (max-width: 1024px){ .donor-cards{ grid-template-columns: repeat(2, minmax(0,1fr)); } }
    @media (max-width: 640px){ .donor-cards{ grid-template-columns: 1fr; } }

    .results-meta{ margin:18px 0 8px; font-weight:600; color:var(--ink-2); }
    .donor-card{
      background:#fff;
      border:1px solid var(--line);
      border-radius:16px;
      box-shadow: var(--shadow);
      padding:18px;
      transition: transform .15s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .donor-card:hover{
      transform: translateY(-3px);
      box-shadow: 0 14px 30px rgba(0,0,0,.12);
      border-color:#ffd5d8;
    }
    .donor-card__row{ display:flex; align-items:center; justify-content:space-between; gap:12px; }
    .donor-badge{
      display:inline-flex; align-items:center; justify-content:center;
      min-width:56px; height:56px; border-radius:999px;
      font-weight:800;
      border:2px solid #ffd5d8;
      box-shadow: inset 0 0 0 6px #fff;
      background: radial-gradient(240px 120px at 30% 20%, #ffe5e8 0%, #fff 70%);
      color: var(--brand);
    }
    .donor-name{ font-size:18px; font-weight:700; color:var(--ink); }
    .donor-meta{ margin-top:10px; display:flex; flex-wrap:wrap; gap:10px; }
    .donor-meta .chip{
      display:inline-flex; align-items:center; gap:8px;
      background:#fff; border:1px solid var(--line); border-radius:999px;
      padding:8px 12px; font-size:14px; color:var(--ink-2);
    }
    .donor-actions{ margin-top:12px; display:flex; gap:10px; flex-wrap:wrap; }
    .btn-copy{
      display:inline-flex; align-items:center; gap:8px;
      border:1px solid #ffd5d8; border-radius:12px; padding:10px 12px; font-weight:700;
      background:#fff; color:var(--brand);
      transition: background .2s ease, border-color .2s ease, transform .04s ease;
      cursor:pointer; text-decoration:none;
    }
    .btn-copy:hover{ background:var(--brand-50); border-color:var(--brand); }
    .no-donors{ text-align:center; margin:26px auto; font-weight:700; color:var(--brand); }
  </style>
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

  <!-- Main -->
  <main class="search-page page-blush">
    <div class="container">
      <div class="search-header">
        <h2>Search Blood Donors</h2>
        <p class="description">Browse all donors, or filter by donor name, blood group, or location.</p>
      </div>

      <form class="search-form" method="GET" action="">
        <div>
          <label for="donor_name">Donor Name</label>
          <input type="text" id="donor_name" name="donor_name"
                 value="<?php echo htmlspecialchars($donor_name); ?>"
                 placeholder="e.g., John Doe">
        </div>

        <div>
          <label for="blood_group">Blood Group</label>
          <input type="text" id="blood_group" name="blood_group"
                 value="<?php echo htmlspecialchars($blood_group); ?>"
                 placeholder="e.g., A+, O-, B">
        </div>

        <div>
          <label for="location">Location</label>
          <input type="text" id="location" name="location"
                 value="<?php echo htmlspecialchars($location); ?>"
                 placeholder="e.g., Dhanmondi">
        </div>

        <button type="submit" class="btn btn-submit">Filter Donors</button>
      </form>
    </div>

    <div class="container results-container">
      <div class="results-meta">
        <?php if ($total > 0): ?>
          <?php echo $total; ?> donor<?php echo $total>1?'s':''; ?> found
        <?php else: ?>
          No donors match your filters.
        <?php endif; ?>
      </div>

      <?php if ($total > 0): ?>
        <div class="donor-cards">
          <?php foreach ($donors as $d): ?>
            <?php
              $donor_name = htmlspecialchars($d['name']);
              $blood_group = htmlspecialchars($d['blood_group']);
              $location = htmlspecialchars($d['location']);
              $contact = htmlspecialchars($d['contact']);
            ?>
            <article class="donor-card" aria-label="Donor card">
                <div class="donor-card__row">
                    <div class="donor-badge" title="Blood group"><?php echo $blood_group !== '' ? $blood_group : '—'; ?></div>
                    <div class="donor-name"><?php echo $donor_name; ?></div>
                </div>

                <div class="donor-meta">
                    <span class="chip" title="Location">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        <?php echo $location !== '' ? $location : 'Not specified'; ?>
                    </span>
                    <span class="chip" title="Contact">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <?php echo $contact !== '' ? $contact : 'Not provided'; ?>
                    </span>
                </div>

                <div class="donor-actions">
                    <?php if ($contact !== ''): ?>
                        <button class="btn-copy" type="button" data-phone="<?php echo $contact; ?>">
                            <i class="fas fa-copy"></i> Copy number
                        </button>
                    <?php endif; ?>
                </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="no-donors">No donors found.</div>
      <?php endif; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="container footer__inner">
      <div class="footer__social">
        <p>Follow us on social media platforms.</p>
        <div class="social-icons">
          <a href="twitter-link"><i class="
