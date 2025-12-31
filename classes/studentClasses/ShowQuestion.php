<?php

require_once "../../classes/Security.php";
require_once "../../classes/Database.php";
require_once "../../config/database.php";


class ShowQuestion{
    public $quiz_id;

    private $pdo;

    public function __construct()
    {
        $this->quiz_id = $_GET['quiz_id'] ?? NULL;
        $this->pdo = Database::getInstance()->getConnection();
        if (!$this->pdo) {
            die("Erreur de connexion à la base de données.");
        }
    }

    public function getAllQuestion(){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE quiz_id = ?");
            $stmt ->execute([$this->quiz_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Erreur lors de la récupération des questions : " . $e->getMessage());
        }
    }
}

?>