<?php

require_once '../../classes/studentClasses/ShowQuestion.php';

$quiz_id = $_GET['quiz_id'];

$showQuestion = new ShowQuestion();
$questions = $showQuestion->getQuestionsByQuiz($quiz_id);


?>

