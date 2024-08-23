<?php
require 'db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate the token
    $query = "SELECT user_id, expires_at FROM password_resets WHERE token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reset = $result->fetch_assoc();
        $user_id = $reset['user_id'];
        $expires_at = $reset['expires_at'];

        // Check if the token has expired
        if (strtotime($expires_at) > time()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                // Update the password
                $query = "UPDATE users SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $new_password, $user_id);
                $stmt->execute();

                // Delete the token from the database
                $query = "DELETE FROM password_resets WHERE token = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $token);
                $stmt->execute();

                echo "Your password has been updated.";
            }
        } else {
            echo "This link has expired.";
        }
    } else {
        echo "Invalid token.";
    }
} else {
    echo "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Reset Password</h1>
    <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
        <label for="new_password">Enter your new password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
