<?php
require_once 'config.php';

// Flaws: inconsistent variable naming, missing braces
class userAuthentication
{
    function validate_user($username, $password) {
        global $pdo;
        
        // Flaw: SQL injection vulnerability
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $pdo->query($query);
        
        // Flaw: No strict comparison
        if ($result->rowCount() == 1)
            return true;
        else
            return false;
    }
}

$message = "";
$auth = new userAuthentication();

// Flaw: No CSRF protection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['username']; // Flaw: Inconsistent variable naming
    $pass = $_POST['password'];     // Flaw: Inconsistent variable naming
    
    // Flaw: No input validation
    if ($auth->validate_user($Username, $pass)) {
        // Flaw: Insecure session management
        $_SESSION['user'] = $Username;
        
        // Flaw: Header after output
        echo "<script>console.log('Login successful');</script>";
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - SED 602 WebApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        
        <?php if ($message) { ?>
            <div class="error">
                <p><?= $message ?></p>
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
                <button type="submit">Login</button>
            </div>
            
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
