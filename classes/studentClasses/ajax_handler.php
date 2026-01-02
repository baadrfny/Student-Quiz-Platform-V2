<?php
// ajax_endpoint.php
session_start();
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/studentClasses/ShowQuestion.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$quiz_id = $_GET['quiz_id'] ?? 0;
$current_id = $_GET['current_id'] ?? 0;
$student_id = $_SESSION['user_id'] ?? 0;

$response = ['success' => false];

switch ($action) {
    case 'get_first_question':
        $showQues = new ShowQuestion();
        $question = $showQues->getFirstQuestion();
        if ($question) {
            $response = ['success' => true, 'question' => $question];
        }
        break;
        
    case 'get_next_question':
        $showQues = new ShowQuestion();
        $question = $showQues->getNextQuestion($current_id);
        if ($question) {
            $response = ['success' => true, 'question' => $question];
        }
        break;
        
    case 'save_answer':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question_id = $_POST['question_id'] ?? 0;
            $answer = $_POST['answer'] ?? '';
            
            $showQues = new ShowQuestion();
            $result = $showQues->saveAnswer($student_id, $question_id, $answer);
            
            $response = ['success' => $result];
        }
        break;
        
    default:
        $response = ['error' => 'Action non valide'];
}

echo json_encode($response);
?>