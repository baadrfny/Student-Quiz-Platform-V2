<?php
session_start();
require_once '../../classes/Database.php';

if (!isset($_POST['question_id'], $_POST['answer'])) die("Data missing");

$question_id = (int)$_POST['question_id'];
$answer = (int)$_POST['answer'];

$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("SELECT correct_option FROM questions WHERE id=:id");
$stmt->execute([':id'=>$question_id]);
$q = $stmt->fetch();

if($answer == $q['correct_option']) $_SESSION['score']++;

$_SESSION['current_question']++;
header('Location: take_quiz.php');
exit;
