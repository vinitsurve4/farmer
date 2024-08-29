<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farmer"; // Update this to your farmer database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch usernames
$sql = "SELECT username FROM user"; // Update query if needed
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $users[] = $row['username'];
    }
}

// Return data as JSON
echo json_encode($users);

$conn->close();
?>
