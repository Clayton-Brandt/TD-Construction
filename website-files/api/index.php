<?php
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

// Establish PDO connection
require 'dbConfig.php';

function get_pdo() {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// Handle JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate JSON
if (!$data || !isset($data['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON or missing action']);
    exit;
}

$pdo = get_pdo();

switch ($data['action']) {
    case 'createUser':
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if (!$username || !$password) {
            echo json_encode(['status' => 'error', 'message' => 'Username and password required']);
            exit;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'User created']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
        break;

    case 'getUser':
        $username = $data['username'] ?? '';

        if (!$username) {
            echo json_encode(['status' => 'error', 'message' => 'Username required']);
            exit;
        }

        $stmt = $pdo->prepare("SELECT id, fullname, username, dob, role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(['status' => 'success', 'user' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
        break;

    // Add more cases like updateUser, deleteUser, etc. as needed

    default:
        echo json_encode(['status' => 'error', 'message' => 'Unknown action']);
        break;
}
?>
