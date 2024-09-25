<?php
// Start a session to store login information
session_start();

// Sample login credentials (for demo purposes; use a database in production)
$admin_username = 'admin';
$admin_password = 'password123';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username and password are correct
    if ($username === $admin_username && $password === $admin_password) {
        // Set session variables to indicate the user is logged in
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Redirect to admin page
        header('Location: admin.php');
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alfido Tech | Admin Login</title>
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body class="sub_page">

<!-- Reuse the header -->
<div class="hero_area">
  <header class="header_section back1">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="index.html">
          <img src="https://www.alfidotech.com/logo02.png" width="270" height="100" alt="Logo" class="responsive">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">Internship</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="service.html">Task</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="price.html">Submission</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="price.html">Verify Certificate</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
</div>

<!-- Login form -->
<div class="container mt-5">
  <h2>Admin Login</h2>
  
  <!-- Display error if any -->
  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" class="form-control" id="username" required>
    </div>
    
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control" id="password" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>

<!-- Reuse the footer -->
<footer class="footer_section">
  <div class="container">
    <p>&copy; <span id="displayYear"></span> All Rights Reserved by Alfido Tech</p>
  </div>
</footer>

<script>
  document.getElementById("displayYear").innerHTML = new Date().getFullYear();
</script>

</body>
</html>
