<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$user_id = $_SESSION['user']['userID'];
$username = $_SESSION['user']['username'];  // Add username
$job_role = $_POST['job_role'];

require_once __DIR__ . '/api/dbConfig.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO job_assignments (user_id, username, job_role) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $username, $job_role);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Job assignment processed successfully for user: $username, Role: $job_role";
header("Location: employee.php");
exit;
?>
