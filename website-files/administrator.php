<?php
// Check if the user is logged in
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');  // Redirect to login page if not logged in
    exit;
}

// Connect to the database
require_once __DIR__ . '/api/dbConfig.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_user'])) {
        $deleteUser = $_POST['delete_user'];

        // Delete from timelogs
        $deleteTimelogs = $conn->prepare("DELETE FROM timelogs WHERE username = ?");
        $deleteTimelogs->bind_param("s", $deleteUser);
        $deleteTimelogs->execute();
        $deleteTimelogs->close();

        // Delete from job_assignments
        $deleteJobs = $conn->prepare("DELETE FROM job_assignments WHERE username = ?");
        $deleteJobs->bind_param("s", $deleteUser);
        $deleteJobs->execute();
        $deleteJobs->close();

        // Delete from availability
        $deleteAvailability = $conn->prepare("DELETE FROM availability WHERE username = ?");
        $deleteAvailability->bind_param("s", $deleteUser);
        $deleteAvailability->execute();
        $deleteAvailability->close();

        // Finally delete from users
        $deleteQuery = "DELETE FROM users WHERE username = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("s", $deleteUser);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['update_rate']) && isset($_POST['username'])) {
        // Update hourly rate
        $newRate = $_POST['update_rate'];
        $username = $_POST['username'];
        $updateQuery = "UPDATE users SET hourly_rate = ? WHERE username = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ds", $newRate, $username);
        $stmt->execute();
        $stmt->close();
    }
}

// Query to fetch all users
$userQuery = "SELECT username, hourly_rate, position FROM users";
$userResults = $conn->query($userQuery);

$conn->close();
?>

<!-- Administrator Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <link rel="icon" type="image/png" href="TDconstruction.png">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Administrator Dashboard</h2>
            <ul>
                <button id="homeBtn" class="home-btn">Go to Login</button>
                <li><a href="#clockin">Clock In/Out</a></li>
                <li><a href="#manageusers">Manage System Users</a></li>
                <li><a href="#payrollsettings">Payroll Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h3 class="dashboard-greeting">Administrator Scum</h3>

            <!-- Clock In/Out Section -->
            <div id="clockin" class="content-section active">
                <h4>Clock In/Out</h4>
                <form action="clockin.php" method="POST">
                    <button type="submit" name="action" value="clock_in">Clock In</button>
                    <button type="submit" name="action" value="clock_out">Clock Out</button>
                </form>
            </div>

            <!-- Manage Users Section -->
            <div id="manageusers" class="content-section">
                <h4>Manage System Users</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Position</th>
                            <th>Hourly Rate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($userResults->num_rows > 0) {
                            $userResults->data_seek(0);
                            while ($row = $userResults->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['position']) . "</td>
                                    <td>" . htmlspecialchars($row['hourly_rate']) . "</td>
                                    <td>
                                        <form method='POST' action=''>
                                            <button type='submit' name='delete_user' value='" . htmlspecialchars($row['username']) . "'>Delete</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Payroll Settings Section -->
            <div id="payrollsettings" class="content-section">
                <h4>Payroll Settings</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Position</th>
                            <th>Current Hourly Rate</th>
                            <th>New Hourly Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($userResults->num_rows > 0) {
                            $userResults->data_seek(0);
                            while ($row = $userResults->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['position']) . "</td>
                                    <td>" . htmlspecialchars($row['hourly_rate']) . "</td>
                                    <td>
                                        <form method='POST' action=''>
                                            <input type='number' name='update_rate' placeholder='New rate' step='0.01' required>
                                            <input type='hidden' name='username' value='" . htmlspecialchars($row['username']) . "'>
                                            <button type='submit'>Update</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>
