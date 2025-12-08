<?php
include 'db.php';

// Check if the Register button was clicked
if (isset($_POST['register'])) {
    // Collect data from form
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']); // encrypt password (kept as-is)
    $role     = $_POST['role'];

    // Insert into users table
    $sql = "INSERT INTO users (name, email, password, role) 
            VALUES ('$name', '$email', '$password', '$role')";
    if (mysqli_query($conn, $sql)) {
        $user_id = mysqli_insert_id($conn); // get the new user’s ID

        // If the user is a Donor → save extra info in donors table (kept as-is)
        if ($role == "donor") {
            $age         = $_POST['age'];
            $gender      = $_POST['gender'];
            $blood_group = $_POST['blood_group'];
            $location    = $_POST['location'];
            $contact     = $_POST['contact'];

            $sql2 = "INSERT INTO donors (user_id, age, gender, blood_group, location, contact) 
                     VALUES ('$user_id', '$age', '$gender', '$blood_group', '$location', '$contact')";
            mysqli_query($conn, $sql2);
        }

        // Redirect to login page (kept as-is)
        header("Location: login.php?success=1");
        exit;
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
          rel="stylesheet" />
</head>
<body class="admin-body">

    <div class="admin-container">
        <!-- Instruction Text -->
        <div class="request-header">
            <h2><span>Sign up today and help save lives.</span><br>Every donation counts!</h2>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="" class="registration-form">
            <div class="form-row">
                <label for="name">Full Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-row">
                <label for="email">Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-row">
                <label for="password">Create Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-row">
                <label for="role">Select Role</label>
                <!-- added id="role" so the toggler can find it -->
                <select name="role" id="role" required>
                    <option value="donor">Donor</option>
                    <option value="seeker">Seeker</option>
                </select>
            </div>

            <!-- Donor Fields (shown only if role is 'donor') -->
            <div id="donorFields" style="display:none;">
                <div class="form-row">
                    <label for="age">Age</label>
                    <input type="number" name="age" min="18" max="65">
                </div>

                <div class="form-row">
                    <label for="gender">Gender</label>
                    <select name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="form-row">
                    <label for="blood_group">Blood Group</label>
                    <input type="text" name="blood_group">
                </div>

                <div class="form-row">
                    <label for="location">Location</label>
                    <input type="text" name="location">
                </div>

                <div class="form-row">
                    <label for="contact">Contact Number</label>
                    <input type="text" name="contact">
                </div>
            </div>

            <button type="submit" name="register" class="btn btn-submit">Register Now</button>
        </form>
    </div>

    <script>
    // Minimal, robust toggler: runs once on load + on change
    (function () {
      const roleSelect = document.getElementById('role');
      const donorFields = document.getElementById('donorFields');
      if (!roleSelect || !donorFields) return;

      function toggleDonorFields() {
        donorFields.style.display =
          roleSelect.value.trim().toLowerCase() === 'donor' ? 'block' : 'none';
      }

      toggleDonorFields();                 // initialize state on page load
      roleSelect.addEventListener('change', toggleDonorFields); // keep updating
    })();
    </script>

</body>
</html>
