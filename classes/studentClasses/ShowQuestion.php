<?php
require_once "../../classes/Security.php";
require_once "../../classes/Database.php";
require_once "../../config/database.php";



class ShowQuestion {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // get all questions for a specific quiz
    public function getQuestionsByQuiz($quiz_id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
        $stmt->execute([':quiz_id' => $quiz_id]);
        return $stmt->fetchAll();
    }
}
