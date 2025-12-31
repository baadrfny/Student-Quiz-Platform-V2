<?php 
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Security.php';
require_once '../../classes/Category.php';
require_once '../../classes/Quiz.php';
require_once '../../classes/studentClasses/quizStudent.php';


echo "<div style='background:yellow; padding:10px; margin:10px;'>";
echo "<h3>Debug Session:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "</div>";



$quizStudent = new QuizStudent();
$quizzes = $quizStudent->getAllCateory(4);

$student_id = $_SESSION['user_id'] ?? 0;
// $student_name = $_SESSION['user_nom'] ?? 'Étudiant';
$student_name = "Badr";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Disponibles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen p-6">
    
    <!-- العنوان البسيط -->
    <div class="max-w-7xl mx-auto mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-graduation-cap text-blue-600 mr-3"></i>
            Quiz Disponibles
        </h1>
        <p class="text-gray-600 mt-2">Choisissez un quiz à commencer</p>
    </div>
    
    <!-- عرض الـ Quiz فقط -->
    <div class="max-w-7xl mx-auto">
        <?php if (empty($quizzes)): ?>
            <!-- لا توجد اختبارات -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-8 text-center">
                <i class="fas fa-clipboard-list text-5xl text-yellow-400 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun quiz disponible</h3>
                <p class="text-gray-600">Les enseignants préparent de nouveaux quiz.</p>
            </div>
        <?php else: ?>
            <!-- عرض الـ Quiz -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($quizzes as $quiz): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition hover:-translate-y-1">
                        <!-- شريط لوني علوي -->
                        <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                        
                        <div class="p-6">
                            <!-- العنوان -->
                            <h3 class="text-xl font-bold text-gray-800 mb-3">
                                <?php echo htmlspecialchars($quiz['titre']); ?>
                            </h3>
                            
                            <!-- الوصف -->
                            <p class="text-gray-600 mb-4 text-sm">
                                <?php 
                                $description = $quiz['description'] ?? 'Testez vos connaissances';
                                echo htmlspecialchars(substr($description, 0, 80));
                                if (strlen($description) > 80) echo '...';
                                ?>
                            </p>
                            
                            <!-- المعلومات -->
                            <div class="flex items-center text-sm text-gray-500 mb-6">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>
                                    <?php echo date('d/m/Y', strtotime($quiz['created_at'])); ?>
                                </span>
                            </div>
                            
                            <!-- زر البدء -->
                            <a href="take_quiz.php?id=<?php echo $quiz['id']; ?>" 
                               class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center py-3 rounded-lg font-semibold transition flex items-center justify-center">
                                <i class="fas fa-play-circle mr-2"></i>
                                Commencer le Quiz
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- إحصائيات بسيطة -->
            <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                <p class="text-gray-700">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Affichage de <strong><?php echo count($quizzes); ?></strong> quiz disponible(s)
                </p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- تذييل بسيط -->
    <footer class="mt-12 pt-8 border-t border-gray-200 text-center text-gray-500 text-sm">
        <p>QuizMaster © 2024 - Interface Étudiant</p>
    </footer>

</body>
</html>