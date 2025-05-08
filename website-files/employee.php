<!-- Employee Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="icon" type="image/png" href="TDconstruction.png">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Employee Dashboard</h2>
            <ul>
                <button id="homeBtn" class="home-btn">Go to Login</button>
                <li><a href="#clockin">Clock In/Out</a></li>
                <li><a href="#jobassignments">Select Job Assignments</a></li>
                <li><a href="#availability">Set Availability</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1 class="dashboard-greeting">Hello Fellow Employee</h1>

            <!-- Clock In/Out Section -->
            <div id="clockin" class="content-section active">
                <h4>Clock In/Out</h4>
                <form action="clockin.php" method="POST">
                    <button name="action" value="clock_in">Clock In</button>
                    <button name="action" value="clock_out">Clock Out</button>
                </form>
            </div>

            <!-- Job Assignments Section -->
            <div id="jobassignments" class="content-section">
                <h4>Select Job Assignments</h4>
                <form action="E_assignJob.php" method="POST">
                    <select name="job_role">
                        <option value="Concrete Pourer">Concrete Pourer</option>
                        <option value="Safety Dude">Safety Dude</option>
                        <option value="Equipment Operator">Equipment Operator</option>
                    </select>
                    <button type="submit">Confirm</button>
                </form>
            </div>

            <!-- Availability Section -->
            <div id="availability" class="content-section">
                <h4>Set Availability</h4>
                <form action="E_setAvailability.php" method="POST">
                    <label for="sunday_start">Sunday Start Time:</label>
                    <input type="time" name="sunday_start" id="sunday_start"><br>
                    <label for="sunday_end">Sunday End Time:</label>
                    <input type="time" name="sunday_end" id="sunday_end"><br>

                    <label for="monday_start">Monday Start Time:</label>
                    <input type="time" name="monday_start" id="monday_start"><br>
                    <label for="monday_end">Monday End Time:</label>
                    <input type="time" name="monday_end" id="monday_end"><br>

                    <label for="tuesday_start">Tuesday Start Time:</label>
                    <input type="time" name="tuesday_start" id="tuesday_start"><br>
                    <label for="tuesday_end">Tuesday End Time:</label>
                    <input type="time" name="tuesday_end" id="tuesday_end"><br>

                    <label for="wednesday_start">Wednesday Start Time:</label>
                    <input type="time" name="wednesday_start" id="wednesday_start"><br>
                    <label for="wednesday_end">Wednesday End Time:</label>
                    <input type="time" name="wednesday_end" id="wednesday_end"><br>

                    <label for="thursday_start">Thursday Start Time:</label>
                    <input type="time" name="thursday_start" id="thursday_start"><br>
                    <label for="thursday_end">Thursday End Time:</label>
                    <input type="time" name="thursday_end" id="thursday_end"><br>

                    <label for="friday_start">Friday Start Time:</label>
                    <input type="time" name="friday_start" id="friday_start"><br>
                    <label for="friday_end">Friday End Time:</label>
                    <input type="time" name="friday_end" id="friday_end"><br>

                    <label for="saturday_start">Saturday Start Time:</label>
                    <input type="time" name="saturday_start" id="saturday_start"><br>
                    <label for="saturday_end">Saturday End Time:</label>
                    <input type="time" name="saturday_end" id="saturday_end"><br>

                    <button type="submit">Save Availability</button>
                </form>
            </div>
        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>
