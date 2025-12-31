<?php 
require_once "../../classes/Security.php";
require_once "../../classes/Database.php";



class quizStudent{
    
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
        if (!$this->pdo) {
            die("Erreur de connexion à la base de données.");
            
        }
    }


    // for show quiz list on student dashboard
    public function getAllCateory($limit = 4){

        try{
            $stmt = $this->pdo->prepare("SELECT `id`, `titre`,`description` ,`created_at` FROM quiz WHERE is_active = 1 ORDER BY created_at DESC LIMIT ?");
            $stmt->execute([$limit]);
            //fetch all katraja3 kolchi , fetch assoc katraja3 m3a les titres 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            ;
        }
    }

    // for show single quiz details in take quiz page
    public function getQuizById($id){
        try{
            $stmt = $this->pdo->prepare("SELECT `id`, `titre`,`description` ,`created_at` FROM quiz WHERE id = ? AND is_active = 1");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            die("Erreur lors de la récupération du quiz : " . $e->getMessage());
        }
    }

    public function canStudentTakeQuiz($quizId, $studentId){
        try{
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM quiz_attempts WHERE quiz_id = ? AND student_id = ?");
            $stmt->execute([$quizId, $studentId]);
            $count = $stmt->fetchColumn();
            return $count == 0; // Retourne true si l'étudiant n'a pas encore tenté le quiz
        }
        catch(PDOException $e) {
            die("Erreur lors de la vérification de la tentative du quiz : " . $e->getMessage());
        }
    }


    
}

?>