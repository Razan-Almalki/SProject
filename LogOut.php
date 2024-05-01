<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other desired location
header("Location: Login.html");
exit();
?>