<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "farmer"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email and new password from AJAX request
$email = $_POST['email'];
$newPassword = $_POST['newPassword'];

// Query to check if email exists
$sql = "SELECT * FROM user WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Email exists, proceed with password update
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // Hash the new password
    $updateSql = "UPDATE user SET password = '$hashedPassword' WHERE email = '$email'";
    
    if ($conn->query($updateSql) === TRUE) {
        echo "success"; // Send success response
    } else {
        echo "Error updating password: " . $conn->error;
    }
} else {
    echo "error"; // Email does not exist
}

$conn->close();
?>
