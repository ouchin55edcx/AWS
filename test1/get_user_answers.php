<?php

// Start or resume the session
session_start();

// Check if user answers are stored in the session
if (isset($_SESSION['user_answers'])) {
    // Return user answers in JSON format
    header('Content-Type: application/json');
    echo json_encode($_SESSION['user_answers']);
} else {
    // No user answers found
    echo json_encode([]);
}

?>
