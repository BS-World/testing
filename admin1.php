<?php
// Database connection details
$url = 'localhost';
$username = 'root';
$password = '';
$database = 'internship'; // Database name

// Create connection
$conn = new mysqli($url, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all records from the applications table
$sql = "SELECT * FROM applications";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Submitted Applications</h2>
        <table class="table table-bordered mt-3">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>WhatsApp Number</th>
                    <th>Internship Domain</th>
                    <th>C.ID Number</th>
                    <th>LinkedIn Profile</th>
                    <th>Task 1: GitHub</th>
                    <th>Task 1: LinkedIn</th>
                    <th>Task 2: GitHub</th>
                    <th>Task 2: LinkedIn</th>
                    <th>Task 3: GitHub</th>
                    <th>Task 3: LinkedIn</th>
                    <th>Payment Status</th>
                    <th>Payment Screenshot</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>"; // Assuming there's an ID column
                        echo "<td>" . htmlspecialchars($row["fullName"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["whatsapp"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["internshipDomain"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["cidno"]) . "</td>";
                        echo "<td><a href='" . htmlspecialchars($row["linkedIn"]) . "' target='_blank'>View</a></td>";
                        echo "<td><a href='" . htmlspecialchars($row["gtask1"]) . "' target='_blank'>View</a></td>";
                        echo "<td><a href='" . htmlspecialchars($row["ltask1"]) . "' target='_blank'>View</a></td>";
                        echo "<td><a href='" . htmlspecialchars($row["gtask2"]) . "' target='_blank'>View</a></td>";
                        echo "<td><a href='" . htmlspecialchars($row["ltask2"]) . "' target='_blank'>View</a></td>";
                        echo "<td><a href='" . htmlspecialchars($row["gtask3"]) . "' target='_blank'>View</a></td>";
                        echo "<td><a href='" . htmlspecialchars($row["ltask3"]) . "' target='_blank'>View</a></td>";
                        echo "<td>" . htmlspecialchars($row["paymentStatus"]) . "</td>";
                        echo "<td><a href='uploads/" . htmlspecialchars($row["paymentScreenshot"]) . "' target='_blank'>View</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='15'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
