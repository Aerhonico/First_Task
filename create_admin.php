<?php
// Create Admin Account Script
// This script creates an admin user in the portfolio_db database

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "portfolio_db";

// Admin credentials
$admin_first_name = "Admin";
$admin_last_name = "User";
$admin_email = "admin@sdca.edu.ph";
$admin_username = "admin";
$admin_password = "Admin@123456"; // Default temporary password - CHANGE THIS AFTER LOGGING IN
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert admin user
$sql = "INSERT INTO users (first_name, last_name, email, username, password, role, account_status) 
        VALUES (?, ?, ?, ?, ?, 'admin', 'approved')";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sssss", $admin_first_name, $admin_last_name, $admin_email, $admin_username, $hashed_password);

if ($stmt->execute()) {
    echo "<div style='padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; font-family: Arial;'>";
    echo "<h2 style='color: #155724; margin-top: 0;'>✓ Admin Account Created Successfully!</h2>";
    echo "<p><strong>Username:</strong> " . htmlspecialchars($admin_username) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($admin_email) . "</p>";
    echo "<p><strong>Temporary Password:</strong> " . htmlspecialchars($admin_password) . "</p>";
    echo "<p style='color: #d9534f;'><strong>⚠️ Important:</strong> Please log in and change this password immediately for security.</p>";
    echo "<p><a href='application/views/admin/login.php' style='color: #004085; text-decoration: underline;'>Go to Admin Login →</a></p>";
    echo "</div>";
} else {
    echo "<div style='padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; font-family: Arial;'>";
    echo "<h2 style='color: #721c24; margin-top: 0;'>✗ Error Creating Admin Account</h2>";
    echo "<p>" . htmlspecialchars($stmt->error) . "</p>";
    echo "</div>";
}

$stmt->close();
$conn->close();
?>
