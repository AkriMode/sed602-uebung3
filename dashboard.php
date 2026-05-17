<?php
require_once 'config.php';

// Flaw: Weak session validation
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header('Location: login.php');
    exit();
}

// Flaw: Undefined function
function get_user_data() {
    // This function is used but not defined properly
    return array('last_login' => date('Y-m-d H:i:s'));
}

// Flaw: Unused variable
$userData = get_user_data();
$lastLoginTime = $userData['last_login'];
$active = true;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - SED 602 WebApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <!-- Flaw: XSS vulnerability -->
            <h2>Welcome back, <?= $user ?>!</h2>
            <p>Your last login: <?= $lastLoginTime ?></p>
            
            <div class="dashboard-widgets">
                <div class="widget">
                    <h3>Recent Activity</h3>
                    <p>No recent activity.</p>
                </div>
                
                <div class="widget">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Edit Profile</a></li>
                        <li><a href="#">Change Password</a></li>
                        <li><a href="#">Privacy Settings</a></li>
                    </ul>
                </div>
            </div>
        </main>
        
        <footer>
            <p>&copy; 2025 SED 602 WebApp</p>
        </footer>
    </div>
</body>
</html>
