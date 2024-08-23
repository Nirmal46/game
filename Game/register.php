<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Handle profile picture upload
    $profile_picture = 'default_profile_picture.jpg'; // Default profile picture
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $profile_picture = $username . '_profile.' . $file_ext;
        move_uploaded_file($file_tmp, 'uploads/' . $profile_picture);
    }

    // Insert the user into the database
    $query = "INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $email, $password, $profile_picture);
    $stmt->execute();

    // Get the user ID of the newly registered user
    $user_id = $conn->insert_id;

    // Create a wallet for the new user with $1 added
    $initial_balance = 0.00;
    $query = "INSERT INTO wallets (user_id, balance) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("id", $user_id, $initial_balance);
    $stmt->execute();

    // Redirect to login or wherever you want after registration
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   <!-- Header -->
   <header>
        <nav>
            <div class="logo">
                <a href="#">
                    <div class="imgg"><img src="zlogo.png" alt="Logo"></div>
                    <div class="name">Neer</div>
                </a>
            </div>
            <div class="menu-icon" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <ul id="nav-links">
            <li><a href="index.php"><i class="fas fa-home" style="color: #ff6347;"></i> Home</a></li>
                <li class="dropdown">
                    <a href="#"><i class="fas fa-concierge-bell" style="color: #ffcc00;"></i> Services</a>
                    <ul class="dropdown-content">
                        <li><a href="#"><i class="fas fa-plus-circle" style="color: #00ffcc;"></i> Create</a></li>
                        <li><a href="#"><i class="fas fa-search" style="color: #ffcc00;"></i> Join</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fas fa-envelope" style="color: #cc66ff;"></i> Contact</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php"><i class="fas fa-user" style="color: #4caf50;"></i> Profile</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt" style="color: #ff4c4c;"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php"><i class="fas fa-sign-in-alt" style="color: #4caf50;"></i> Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>    
    </header>


    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
