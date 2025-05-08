<?php
// signup.php
require_once 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $fullname = $data['fullname'] ?? '';
    $username = $data['username'] ?? '';
    $password = password_hash($data['password'] ?? '', PASSWORD_BCRYPT);
    $dob = $data['dob'] ?? '';
    $position = $data['position'] ?? '';
    $adminPasswordInput = $data['adminPassword'] ?? '';

    // Check admin signup password
    $actualAdminPassword = 'password'; // REPLACE with secure .env or config

    if ($adminPasswordInput !== $actualAdminPassword) {
        echo json_encode(["status" => "error", "message" => "Invalid boss password."]);
        exit;
    }
    

    try {
        // Connect to DB
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check for duplicate username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "error", "message" => "Username already taken."]);
        } else {
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password, dob, position) 
                                   VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$fullname, $username, $password, $dob, $position]);

            echo json_encode(["status" => "success", "message" => "User registered successfully."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
}
?>
