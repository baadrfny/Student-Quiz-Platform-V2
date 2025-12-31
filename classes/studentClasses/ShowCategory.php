<?php

require_once "../../classes/Security.php";
require_once "../../classes/Database.php";
require_once "../../config/database.php";



// var_dump($categorie_id);

class ShowCategory{

    public $categorie_id;
    
    private $pdo;

    public function __construct()
    {
        $this->categorie_id = $_GET['id'] ?? null ;
        $this->pdo = Database::getInstance()->getConnection();
        if (!$this->pdo) {   
            die("Erreur de connexion à la base de données.");
        }
    }

    public function GetQuiz(){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM quiz WHERE categorie_id = ?");
            $stmt->execute([$this->categorie_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e) {
            die("Erreur lors de la récupération des quiz : " . $e->getMessage());
        }
    }
}






?>