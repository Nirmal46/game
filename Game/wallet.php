<?php
session_start();
require 'db_connection.php'; // Ensure this file connects to your database

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch the current wallet balance
$query = "SELECT balance FROM wallets WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$wallet = $result->fetch_assoc();
$current_balance = $wallet ? $wallet['balance'] : 0;

// Handle adding funds
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['amount'])) {
    $amount = floatval($_POST['amount']);
    if ($amount > 0) {
        // Add funds to wallet
        $query = "UPDATE wallets SET balance = balance + ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('di', $amount, $user_id);
        $stmt->execute();

        // Record transaction
        $query = "INSERT INTO transactions (user_id, amount, description, date) VALUES (?, ?, 'Added Funds', NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('id', $user_id, $amount);
        $stmt->execute();

        header('Location: wallet.php'); // Refresh the page to show updated balance
        exit();
    } else {
        echo "Invalid amount.";
    }
}

// Fetch transaction history
$query = "SELECT * FROM transactions WHERE user_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$transactions = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
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
                <li><a href="tournaments.php"><i class="fas fa-trophy" style="color: #00ffcc;"></i> Tournaments</a></li>
                <li><a href="profile.php"><i class="fas fa-user" style="color: #4caf50;"></i> Profile</a></li>
                <li><a href="add_funds.php"><i class="fas fa-wallet" style="color: #ffcc00;"></i> Add Funds</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt" style="color: #ff4c4c;"></i> Logout</a></li>
            </ul>
        </nav>    
    </header>

    <main>
        <section class="wallet">
            <h1>Your Wallet</h1>
            <p>Current Balance: $<?php echo number_format($current_balance, 2); ?></p>
            
            <h2>Transaction History</h2>
            <?php if ($transactions->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($transaction = $transactions->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date('F j, Y, g:i a', strtotime($transaction['date'])); ?></td>
                                <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No transactions found.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <!-- Include your footer here -->
    </footer>
</body>
</html>
