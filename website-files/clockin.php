<?php
session_start();

$user_id = $_SESSION['user']['userID']; // Get user ID from session
$username = $_SESSION['user']['username']; // Get username from session
$action = $_POST['action'] ?? null; // Get clock in/out action

if (!$action) {
    die("Action not specified.");
}

require_once __DIR__ . '/api/dbConfig.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Updated table name: timeLogs
$stmt = $conn->prepare("INSERT INTO timeLogs (user_id, username, action) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $username, $action);
$stmt->execute();
$stmt->close();
$conn->close();

// Ensure position is set and has a value
$position = trim($_SESSION['user']['position']); // Remove any whitespace
echo "Position: $position"; // For debugging purposes

switch ($position) {
    case 'Supervisor':
        header("Location: supervisor.php");
        exit;
    case 'Administrator':
        header("Location: administrator.php");
        exit;
    default:
        // Log or handle unexpected positions
        error_log("Unexpected position: $position");
        header("Location: employee.php");
        exit;
}