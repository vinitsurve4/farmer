<?php
// Database connection settings

$db = 'farmer';



try {
    // Create a new PDO instance
    $pdo = new PDO("dbname=$db;charset=utf8");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $userType = trim($_POST['userType'] ?? '');

        if (empty($username) || empty($password) || empty($userType)) {
            echo 'All fields are required.';
            exit;
        }

        // Prepare the SQL query to select the user
        $stmt = $pdo->prepare("SELECT password FROM user WHERE username = :username AND user_type = :userType LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':userType', $userType);
        $stmt->execute();

        // Fetch the user record
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            echo 'Login successful';
        } else {
            echo 'Invalid credentials';
        }
    } else {
        http_response_code(405);
        echo 'Method Not Allowed';
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Database error: ' . $e->getMessage();
}
?>
