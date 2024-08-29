<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$farmer_db = "farmer"; // Replace with your actual farmer database name
$vendor_db = "vendors"; // Replace with your actual vendor database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$user = $_POST['username'];
$email = $_POST['email'];
$mobile_no = $_POST['mobile_no'];
$pass = $_POST['password'];
$role = $_POST['role'];

// Determine the database and table based on the role
if ($role === 'Farmer') {
    $dbname = $farmer_db;
    $table = 'user'; // Table name for farmers
} elseif ($role === 'Vendor') {
    $dbname = $vendor_db;
    $table = 'users'; // Table name for vendors
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid role']);
    exit;
}

// Select the appropriate database
$conn->select_db($dbname);

// Hash the password
$hashed_password = password_hash($pass, PASSWORD_BCRYPT);

// Prepare SQL statement
$sql = "INSERT INTO $table (username, email, mobile_no, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $user, $email, $mobile_no, $hashed_password);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
}

// Close connections
$stmt->close();
$conn->close();
?>
