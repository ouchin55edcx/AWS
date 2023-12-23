<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Optionally, regenerate the session ID for security
session_regenerate_id();

// Redirect or do any other actions after clearing the session
header("Location: your_redirect_page.php");
exit();
?>
