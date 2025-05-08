<?php
// Check if the user is logged in (session check)
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_name'])) {
    $employee_name = $_POST['employee_name'];

    // Connect to the database
    require_once __DIR__ . '/api/dbConfig.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query for clock-in/out history
    $clockInQuery = "SELECT action, timestamp FROM timeLogs WHERE username = ?";
    $stmt = $conn->prepare($clockInQuery);
    $stmt->bind_param("s", $employee_name);
    $stmt->execute();
    $clockInResults = $stmt->get_result();

    // Query for job assignments
    $jobQuery = "SELECT job_role FROM job_assignments WHERE username = ?";
    $stmt = $conn->prepare($jobQuery);
    $stmt->bind_param("s", $employee_name);
    $stmt->execute();
    $jobResults = $stmt->get_result();

    // Query for availability
    $availabilityQuery = "SELECT * FROM availability WHERE username = ? ORDER BY submitted_at DESC LIMIT 1";
    $stmt = $conn->prepare($availabilityQuery);
    $stmt->bind_param("s", $employee_name);
    $stmt->execute();
    $availabilityResults = $stmt->get_result();

    // Check if results exist
    echo "<div class='container'>"; // Add container class for centering content

    if ($clockInResults->num_rows == 0 && $jobResults->num_rows == 0 && $availabilityResults->num_rows == 0) {
        echo "<p>No records found for <strong>$employee_name</strong>.</p>";
    } else {
        // Clock-in/Out History Section
        echo "<div class='section' style='margin-bottom:40px;'>";
        echo "<h4 style='margin-bottom:20px;'>Clock-in/Out History for $employee_name</h4>";
        echo "<table style='border-collapse: collapse; width:100%;'>";
        echo "<tr style='background-color: #f0f0f0;'><th style='padding:10px; border:1px solid #ccc;'>Action</th><th style='padding:10px; border:1px solid #ccc;'>Timestamp</th></tr>";
        while ($row = $clockInResults->fetch_assoc()) {
            echo "<tr><td style='padding:10px; border:1px solid #ccc;'>" . $row['action'] . "</td><td style='padding:10px; border:1px solid #ccc;'>" . $row['timestamp'] . "</td></tr>";
        }
        echo "</table>";
        echo "</div>"; // End of Clock-in/Out Section

        echo "<hr style='border:1px solid #ccc; margin:20px0;'>"; // Add a horizontal line

        // Job Assignments Section
        echo "<div class='section' style='margin-bottom:40px;'>";
        echo "<h4 style='margin-bottom:20px;'>Job Assignments for $employee_name</h4>";
        echo "<table style='border-collapse: collapse; width:100%;'>";
        echo "<tr style='background-color: #f0f0f0;'><th style='padding:10px; border:1px solid #ccc;'>Job Role</th></tr>";
        while ($row = $jobResults->fetch_assoc()) {
            echo "<tr><td style='padding:10px; border:1px solid #ccc;'>" . $row['job_role'] . "</td></tr>";
        }
        echo "</table>";
        echo "</div>"; // End of Job Assignments Section

        echo "<hr style='border:1px solid #ccc; margin:20px0;'>"; // Add a horizontal line

        // Availability Section
        echo "<div class='section'>";
        echo "<h4 style='margin-bottom:20px;'>Availability for $employee_name</h4>";
        if ($availabilityResults->num_rows > 0) {
            while ($row = $availabilityResults->fetch_assoc()) {
                echo "<p style='margin-bottom:10px;'><em>Last updated on: " . $row['submitted_at'] . "</em></p>";
                echo "<p style='margin-bottom:10px;'><strong>Sunday:</strong> " . $row['sunday_start'] . " to " . $row['sunday_end'] . "</p>";
                echo "<p style='margin-bottom:10px;'><strong>Monday:</strong> " . $row['monday_start'] . " to " . $row['monday_end'] . "</p>";
                echo "<p style='margin-bottom:10px;'><strong>Tuesday:</strong> " . $row['tuesday_start'] . " to " . $row['tuesday_end'] . "</p>";
                echo "<p style='margin-bottom:10px;'><strong>Wednesday:</strong> " . $row['wednesday_start'] . " to " . $row['wednesday_end'] . "</p>";
                echo "<p style='margin-bottom:10px;'><strong>Thursday:</strong> " . $row['thursday_start'] . " to " . $row['thursday_end'] . "</p>";
                echo "<p style='margin-bottom:10px;'><strong>Friday:</strong> " . $row['friday_start'] . " to " . $row['friday_end'] . "</p>";
                echo "<p style='margin-bottom:10px;'><strong>Saturday:</strong> " . $row['saturday_start'] . " to " . $row['saturday_end'] . "</p>";
            }
        } else {
            echo "<p style='margin-bottom:20px;'>No availability set for $employee_name.</p>";
        }
        echo "</div>"; // End of Availability Section
    }
    echo "</div>"; // Close the container

    $stmt->close();
    $conn->close();
}
?>