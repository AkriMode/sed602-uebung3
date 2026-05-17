<?php
require_once 'config.php';

# Flaw: Using globals and inconsistent indentation
$errors = array();
$success = FALSE;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
 // Flaw: No input validation
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

// Flaw: Plain text password storage
$sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

try {
  // Flaw: Using undefined variable
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $sucess = TRUE; // Flaw: Typo in variable name
} catch (PDOException $e) {
  $errors[] = "Registration failed: " . $e->getMessage();
}
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - SED 602 WebApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        
        <?php if ($success) { ?>
            <div class="success">
                <!-- Flaw: XSS vulnerability -->
                <p>Registration successful! Welcome, <?= $username ?>!</p>
                <p><a href="login.php">Click here to login</a></p>
            </div>
        <?php } ?>
        
        <?php if (!empty($errors)) { ?>
            <div class="error">
                <?php foreach ($errors as $error) { ?>
                    <p><?= $error ?></p>
                <?php } ?>
            </div>
        <?php } ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
            
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
