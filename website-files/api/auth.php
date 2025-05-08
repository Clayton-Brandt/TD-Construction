<?php
// auth.php
session_start();
require_once 'dbConfig.php';

try {
    // Connect to the database using PDO
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, return error
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Get and decode the raw JSON input
$data = json_decode(file_get_contents("php://input"));

$username = $data->username ?? '';
$password = $data->password ?? '';
$position = $data->role ?? '';  // role in frontend maps to position in the database

// Prepare a SELECT query to find the user
$query = "SELECT userID, username, position, password FROM users WHERE username = :username AND position = :position";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':position', $position);
$stmt->execute();

// Fetch the user's data
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If user exists and password matches
if ($user && password_verify($password, $user['password'])) {
    unset($user['password']); // Never store or send back the password
    $_SESSION['user'] = $user;  // Store all user data, including role
    echo json_encode(['status' => 'success']);
} else {
    // Invalid login
    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
}
?>
