<?php
session_start();
require 'db_connection.php'; // Include the database connection

// Fetch upcoming tournaments
$query = "SELECT * FROM tournaments WHERE start_date > NOW() ORDER BY start_date ASC LIMIT 3";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
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
                <li><a href="about.php"><i class="fas fa-info-circle" style="color: #00ffcc;"></i> About</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php"><i class="fas fa-user" style="color: #4caf50;"></i> Profile</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt" style="color: #ff4c4c;"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php"><i class="fas fa-sign-in-alt" style="color: #4caf50;"></i> Login</a></li>
                    <li><a href="register.php"><i class="fas fa-user-plus" style="color: #4caf50;"></i> Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>    
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="cta-buttons">
                <a href="tournaments.php" class="btn">Join a Tournament</a>
                <a href="add_funds.php" class="btn">Add Funds</a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="feature">
                <h2>Exciting Tournaments</h2>
                <p>Join thrilling tournaments and compete for amazing prizes!</p>
            </div>
            <div class="feature">
                <h2>Secure Wallet</h2>
                <p>Your funds are protected with our secure wallet system.</p>
            </div>
            <div class="feature">
                <h2>Track Your Stats</h2>
                <p>Monitor your performance and progress in tournaments.</p>
            </div>
        </section>

        <!-- Upcoming Tournaments Section -->
        <section class="upcoming-tournaments">
            <h2>Upcoming Tournaments</h2>
            <ul>
                <?php while($row = $result->fetch_assoc()): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p><strong>Start Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($row['start_date'])); ?></p>
                        <p><strong>Entry Fee:</strong> $<?php echo number_format($row['entry_fee'], 2); ?></p>
                        <p><strong>Prize Pool:</strong> $<?php echo number_format($row['prize_pool'], 2); ?></p>
                        <a href="tournament_details.php?id=<?php echo $row['id']; ?>" class="btn">View Details</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <ul>
            <li><a href="privacy-policy.php">Privacy Policy</a></li>
            <li><a href="terms-of-service.php">Terms of Service</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </footer>
</body>
</html>
