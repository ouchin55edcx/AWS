<?php
include 'model/model.php';

function fetchNextQuestion() {
    $question = getQuestion();
    echo json_encode($question);
}

?>
