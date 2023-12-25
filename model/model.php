<?php
function getQuestion() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "aws";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();

    if (!isset($_SESSION['displayed_questions'])) {
        $allQuestionIdsQuery = "SELECT id FROM question";
        $allQuestionIdsResult = $conn->query($allQuestionIdsQuery);
        $_SESSION['displayed_questions'] = array();
        while ($row = $allQuestionIdsResult->fetch_assoc()) {
            $_SESSION['displayed_questions'][] = $row['id'];
        }
    }

    if (empty($_SESSION['displayed_questions'])) {
        unset($_SESSION['displayed_questions']);
    }

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

    $queryChoices = "SELECT id AS choice_id, choice_content FROM choice WHERE question_id = " . $question['question_id'];

    $resultChoices = $conn->query($queryChoices);

    $question['choices'] = array();

    while ($rowChoices = $resultChoices->fetch_assoc()) {
        $question['choices'][] = array(
            'choice_id' => $rowChoices['choice_id'],
            'choice_content' => $rowChoices['choice_content']
        );
    }

    $_SESSION['current_question_id'] = $question['question_id'];

    $conn->close();

    return $question;
}
?>
