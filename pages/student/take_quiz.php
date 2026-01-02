<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Security.php';
require_once '../../classes/studentClasses/ShowQuestion.php';


// Security: Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to take the quiz.");
}
$etudiant_id = $_SESSION['user_id'];

// Check Quiz ID
if(!isset($_GET['quiz_id'])){
    die("Quiz ID missing");
}
$quiz_id = (int)$_GET['quiz_id'];

$conn = Database::getInstance()->getConnection();

// --- NEW: CHECK FOR EXISTING ATTEMPT ---
$check_query = "SELECT id FROM results WHERE etudiant_id = :etudiant_id AND quiz_id = :quiz_id";
$check_stmt = $conn->prepare($check_query);
$check_stmt->execute([':etudiant_id' => $etudiant_id, ':quiz_id' => $quiz_id]);

if ($check_stmt->fetch()) {
    echo "
    <!DOCTYPE html>
    <html>
    <head><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-gray-100 flex items-center justify-center min-h-screen text-center'>
        <div class='bg-white p-8 rounded-xl shadow-lg max-w-md'>
            <h2 class='text-2xl font-bold text-red-600 mb-4'>Tentative limitée</h2>
            <p class='text-gray-600 mb-6'>Vous avez déjà complété ce quiz. Une seule tentative est autorisée.</p>
            <a href='dashboard.php' class='bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition'>Retour</a>
        </div>
    </body>
    </html>";
    exit;
}
// --- END CHECK ---

$showQ = new ShowQuestion();
$questions = $showQ->getQuestionsByQuiz($quiz_id);

if(empty($questions)){
    die("No questions found for this quiz");
}

if(!isset($_SESSION['current_question'])) $_SESSION['current_question'] = 0;
if(!isset($_SESSION['score'])) $_SESSION['score'] = 0;

// Save Results at the end
if($_SESSION['current_question'] >= count($questions)){
    $final_score = $_SESSION['score'];
    $total_questions_count = count($questions);

    try {
        $query = "INSERT INTO results (quiz_id, etudiant_id, score, total_questions, created_at) 
                  VALUES (:quiz_id, :etudiant_id, :score, :total_questions, NOW())";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':quiz_id'         => $quiz_id,
            ':etudiant_id'     => $etudiant_id,
            ':score'           => $final_score,
            ':total_questions' => $total_questions_count
        ]);

        echo "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.tailwindcss.com'></script>
        </head>
        <body class='bg-gray-100 flex items-center justify-center min-h-screen'>
            <div class='bg-white p-10 rounded-xl shadow-2xl text-center max-w-md w-full'>
                <div class='mb-4 text-green-500'>
                    <svg class='w-20 h-20 mx-auto' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                    </svg>
                </div>
                <h2 class='text-3xl font-bold text-gray-800 mb-4'>Quiz Terminé !</h2>
                <p class='text-xl text-gray-600 mb-6'>Votre score est : <span class='font-bold text-indigo-600 text-3xl'>$final_score / $total_questions_count</span></p>
                <a href='student_dashboard.php' class='inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300'>Retour au Dashboard</a>
            </div>
        </body>
        </html>";

        unset($_SESSION['current_question']);
        unset($_SESSION['score']);
        exit;

    } catch (PDOException $e) {
        die("Erreur SQL lors de l'enregistrement : " . $e->getMessage());
    }
}

$index = $_SESSION['current_question'];
$q = $questions[$index];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])){
    $selected_option = (int)$_POST['answer'];
    $correct_option = (int)$q['correct_option'];

    if($selected_option === $correct_option){
        $_SESSION['score']++;
    }

    $_SESSION['current_question']++;
    header("Location: take_quiz.php?quiz_id=$quiz_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz en cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl mx-4">
    <div class="w-full bg-gray-200 rounded-full h-2 mb-6">
        <div class="bg-indigo-600 h-2 rounded-full" style="width: <?= (($index + 1) / count($questions)) * 100 ?>%"></div>
    </div>

    <h2 class="text-xl font-bold mb-4 text-gray-700">Question <?= $index + 1 ?> / <?= count($questions) ?></h2>
    <p class="text-lg mb-8 text-gray-800 font-medium"><?= htmlspecialchars($q['question']) ?></p>

    <form method="POST" class="space-y-3">
        <?php for($i=1; $i<=4; $i++): ?>
            <?php if(!empty($q['option'.$i])): ?>
                <label class="flex items-center p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                    <input type="radio" name="answer" value="<?= $i ?>" class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                    <span class="ml-4 text-gray-700 group-hover:text-indigo-700"><?= htmlspecialchars($q['option'.$i]) ?></span>
                </label>
            <?php endif; ?>
        <?php endfor; ?>

        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg hover:shadow-indigo-200 transition-all transform active:scale-95">
                <?= ($index + 1) === count($questions) ? 'Terminer' : 'Suivant →' ?>
            </button>
        </div>
    </form>
</div>

</body>
</html>