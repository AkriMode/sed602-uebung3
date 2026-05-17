<?php
require_once 'config.php';

// Flaw: Incomplete session destruction
session_unset();
// Missing session_destroy()

// Flaw: No exit after redirect
header('Location: login.php');
?>
