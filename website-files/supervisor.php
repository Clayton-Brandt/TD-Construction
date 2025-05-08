<!-- Supervisor Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="icon" type="image/png" href="TDconstruction.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Supervisor Dashboard</h2>
            <ul>
                <button id="homeBtn" class="home-btn">Go to Login</button>
                <li><a href="#clockin">Clock In/Out</a></li>
                <li><a href="#queryrecords">Query Employee Work Records</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h3 class="dashboard-greeting">Good Day Supervisor</h3>

            <!-- Clock In/Out Section -->
            <div id="clockin" class="content-section active">
                <h4>Clock In/Out</h4>
                <form action="clockin.php" method="POST">
                    <button type="submit" name="action" value="clock_in">Clock In</button>
                    <button type="submit" name="action" value="clock_out">Clock Out</button>
                </form>
            </div>

            <!-- Query Employee Records Section -->
            <div id="queryrecords" class="content-section">
                <h4>Query Employee Work Records</h4>
                <form id="searchForm" method="POST">
                    <input type="text" id="employee_name" name="employee_name" placeholder="Enter Employee Username" required>
                    <button type="submit">Search</button>
                </form>

                <!-- Display Employee Records -->
                <div id="resultSection"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#searchForm').submit(function(e) {
                e.preventDefault(); // Prevent form submission and page reload

                var employee_name = $('#employee_name').val(); // Get input value

                $.ajax({
                    url: 'S_query.php',  // Endpoint for querying employee
                    method: 'POST',
                    data: { employee_name: employee_name },
                    success: function(response) {
                        // Display response in result section
                        $('#resultSection').html(response);
                    },
                    error: function() {
                        $('#resultSection').html('<p>An error occurred. Please try again.</p>');
                    }
                });
            });
        });
    </script>

    <script src="dashboard.js"></script>
</body>
</html>
