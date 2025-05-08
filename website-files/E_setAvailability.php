<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$userID = $_SESSION['user']['userID'];
$username = $_SESSION['user']['username'];  // Get username from session

// Collect availability data
$sunday_start = $_POST['sunday_start'] ?? NULL;
$sunday_end = $_POST['sunday_end'] ?? NULL;
$monday_start = $_POST['monday_start'] ?? NULL;
$monday_end = $_POST['monday_end'] ?? NULL;
$tuesday_start = $_POST['tuesday_start'] ?? NULL;
$tuesday_end = $_POST['tuesday_end'] ?? NULL;
$wednesday_start = $_POST['wednesday_start'] ?? NULL;
$wednesday_end = $_POST['wednesday_end'] ?? NULL;
$thursday_start = $_POST['thursday_start'] ?? NULL;
$thursday_end = $_POST['thursday_end'] ?? NULL;
$friday_start = $_POST['friday_start'] ?? NULL;
$friday_end = $_POST['friday_end'] ?? NULL;
$saturday_start = $_POST['saturday_start'] ?? NULL;
$saturday_end = $_POST['saturday_end'] ?? NULL;

require_once __DIR__ . '/api/dbConfig.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert userID and username into availability table
$stmt = $conn->prepare("INSERT INTO availability 
(userID, username, sunday_start, sunday_end, monday_start, monday_end, tuesday_start, tuesday_end, wednesday_start, wednesday_end, thursday_start, thursday_end, friday_start, friday_end, saturday_start, saturday_end, submitted_at) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

$stmt->bind_param("isssssssssssssss", $userID, $username, $sunday_start, $sunday_end, $monday_start, $monday_end, $tuesday_start, $tuesday_end, $wednesday_start, $wednesday_end, $thursday_start, $thursday_end, $friday_start, $friday_end, $saturday_start, $saturday_end);

$stmt->execute();
$stmt->close();
$conn->close();

header("Location: employee.php");
exit;
?>
