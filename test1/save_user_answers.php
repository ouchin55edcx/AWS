<?php

session_start();

// Handle the data sent from the client
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $questionId = $data['questionId'];
    $selectedChoices = $data['selectedChoices'];

    // Save the data in the session (adjust based on your session management approach)
    $_SESSION['user_answers'][$questionId] = $selectedChoices;

    // Optional: Return a response to the client
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
} else {
    // Handle error case
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error']);
}

?>
