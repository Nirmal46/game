<?php
session_start();
require 'db_connection.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check credentials
    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <li><a href="register.php"><i class="fas fa-user-plus" style="color: #4caf50;"></i> Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>    
    </header>

    <!-- Header (same as index.php) -->

    <main>
        <section class="login">
            <h2>Login</h2>
            <form method="post" action="login.php">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
                <?php if (isset($error)): ?>
                    <p><?php echo htmlspecialchars($error); ?> <a href="forgot_password.php">Forgot Password?</a></p>
                <?php endif; ?>
            </form>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </section>
    </main>

    <!-- Footer (same as index.php) -->
</body>
</html>
