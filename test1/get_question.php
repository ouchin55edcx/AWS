<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aws";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start or resume the session
session_start();

// Check if the session variable for displayed questions is not set
if (!isset($_SESSION['displayed_questions'])) {
    // Fetch all question IDs
    $allQuestionIdsQuery = "SELECT id FROM question";
    $allQuestionIdsResult = $conn->query($allQuestionIdsQuery);
    $_SESSION['displayed_questions'] = array();
    while ($row = $allQuestionIdsResult->fetch_assoc()) {
        $_SESSION['displayed_questions'][] = $row['id'];
    }
}

// Check if all questions have been displayed
if (empty($_SESSION['displayed_questions'])) {
    // If all questions have been displayed, reset the session variable
    unset($_SESSION['displayed_questions']);
}

// Fetch a random question that has not been displayed
$randomQuestionId = array_pop($_SESSION['displayed_questions']);
$query = "SELECT q.id, q.content, t.name AS theme_name 
          FROM question q
          JOIN theme t ON q.theme_id = t.id
          WHERE q.id = $randomQuestionId";

$result = $conn->query($query);

$question = array();

while ($row = $result->fetch_assoc()) {
    $question['question_id'] = $row['id'];
    $question['question_content'] = $row['content'];
    $question['question_theme'] = $row['theme_name'];
}

// Fetch choices for the selected question
$queryChoices = "SELECT id AS choice_id, choice_content FROM choice WHERE question_id = " . $question['question_id'];

$resultChoices = $conn->query($queryChoices);

$question['choices'] = array();

while ($rowChoices = $resultChoices->fetch_assoc()) {
    $question['choices'][] = array(
        'choice_id' => $rowChoices['choice_id'],
        'choice_content' => $rowChoices['choice_content']
    );
}

// Save the current question ID in the session
$_SESSION['current_question_id'] = $question['question_id'];

// Close the database connection
$conn->close();

echo json_encode($question);
?>
