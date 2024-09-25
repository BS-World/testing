<?php
// Database connection
$servername = "localhost"; // Change this to your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "internship";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$candidate_id_search = '';
$search_result = [];
$current_edit_id = '';
$current_edit_name = '';
$current_edit_domain = '';
$current_edit_duration = '';
$current_edit_certificate = '';

// Handle form submission for adding/updating entries
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search'])) {
        $candidate_id_search = $_POST['candidate_id_search'];
        $sql = "SELECT * FROM certificate WHERE candidate_id='$candidate_id_search'";
        $search_result = $conn->query($sql);
    } else {
        $candidate_id = $_POST['candidate_id'];
        $name = $_POST['name'];
        $domain = $_POST['domain'];
        $duration = $_POST['duration'];

        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["certificate"]["name"]);
        move_uploaded_file($_FILES["certificate"]["tmp_name"], $target_file);

        // Insert or update record
        if (isset($_POST['add'])) {
            $sql = "INSERT INTO certificate (candidate_id, name, domain, duration, certificate) VALUES ('$candidate_id', '$name', '$domain', '$duration', '$target_file')";
            $conn->query($sql);
        } elseif (isset($_POST['update'])) {
            $sql = "UPDATE certificate SET name='$name', domain='$domain', duration='$duration', certificate='$target_file' WHERE candidate_id='$candidate_id'";
            $conn->query($sql);
        }
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $candidate_id = $_GET['delete'];
    $sql = "DELETE FROM certificate WHERE candidate_id='$candidate_id'";
    $conn->query($sql);
}

// Handle edit action
if (isset($_GET['edit'])) {
    $current_edit_id = $_GET['edit'];
    $sql = "SELECT * FROM certificate WHERE candidate_id='$current_edit_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_edit_name = $row['name'];
        $current_edit_domain = $row['domain'];
        $current_edit_duration = $row['duration'];
        $current_edit_certificate = $row['certificate']; // Existing certificate path
    }
}

// Fetch all records if no search
if (empty($candidate_id_search)) {
    $sql = "SELECT * FROM certificate";
    $result = $conn->query($sql);
} else {
    $result = $search_result; // Use search result if searching
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<body>

<h1>Internship Applications</h1>

<!-- Search Form -->
<form method="post">
    <label>Search by Candidate ID:</label><br>
    <input type="text" name="candidate_id_search" value="<?php echo htmlspecialchars($candidate_id_search); ?>">
    <input type="submit" name="search" value="Search">
</form>

<!-- Form for adding/updating data -->
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="candidate_id" value="<?php echo htmlspecialchars($current_edit_id); ?>">
    <label>Candidate ID:</label><br>
    <input type="text" name="candidate_id" required value="<?php echo htmlspecialchars($current_edit_id); ?>" <?php echo $current_edit_id ? 'readonly' : ''; ?>><br>
    <label>Name:</label><br>
    <input type="text" name="name" required value="<?php echo htmlspecialchars($current_edit_name); ?>"><br>
    <label>Domain:</label><br>
    <input type="text" name="domain" required value="<?php echo htmlspecialchars($current_edit_domain); ?>"><br>
    <label>Duration:</label><br>
    <input type="text" name="duration" required value="<?php echo htmlspecialchars($current_edit_duration); ?>"><br>
    <label>Certificate:</label><br>
    <input type="file" name="certificate">
    <small>Leave blank to keep existing file: <a href="<?php echo $current_edit_certificate; ?>">Download</a></small><br>
    <input type="submit" name="add" value="Add Application">
    <input type="submit" name="update" value="Update Application">
</form>

<h2>Application List</h2>
<table border="1">
    <tr>
        <th>Candidate ID</th>
        <th>Name</th>
        <th>Domain</th>
        <th>Duration</th>
        <th>Certificate</th>
        <th>Actions</th>
    </tr>
    <?php if (empty($candidate_id_search)): ?>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['candidate_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['domain']; ?></td>
            <td><?php echo $row['duration']; ?></td>
            <td><a href="<?php echo $row['certificate']; ?>">Download</a></td>
            <td>
                <a href="?edit=<?php echo $row['candidate_id']; ?>">Edit</a>
                <a href="?delete=<?php echo $row['candidate_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <?php if ($search_result->num_rows > 0): ?>
            <?php while ($row = $search_result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['candidate_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['domain']; ?></td>
                <td><?php echo $row['duration']; ?></td>
                <td><a href="<?php echo $row['certificate']; ?>">Download</a></td>
                <td>
                    <a href="?edit=<?php echo $row['candidate_id']; ?>">Edit</a>
                    <a href="?delete=<?php echo $row['candidate_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No results found for Candidate ID "<?php echo htmlspecialchars($candidate_id_search); ?>"</td>
            </tr>
        <?php endif; ?>
    <?php endif; ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
