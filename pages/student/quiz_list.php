<?php

require_once '../../classes/Database.php';
require_once '../../classes/Security.php';
require_once '../../classes/Category.php';
require_once '../../classes/Quiz.php';
require_once 'C:\laragon\www\Student-Quiz-Platform-V2\classes\studentClasses\ShowCategory.php';


$showCat = new ShowCategory();
$quizzes = $showCat->GetQuiz();



$student_id = $_SESSION['user_id'] ?? 0;
$student_name = $_SESSION['user_nom'] ?? 'Étudiant';



?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Quiz</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Animation pour les cartes */
        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        
        /* Gradient personnalisé */
        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .gradient-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- NAVBAR -->
    <nav class="gradient-primary text-white shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo et nom du site -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">QuizMaster</h1>
                        <p class="text-sm text-blue-200">Espace Étudiant</p>
                    </div>
                </div>
                
                <!-- Menu de navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="dashboard.php" class="font-semibold hover:text-blue-200 transition">
                        <i class="fas fa-home mr-2"></i>Tableau de Bord
                    </a>
                    <a href="categories.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-folder mr-2"></i>Catégories
                    </a>
                    <a href="history.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-history mr-2"></i>Historique
                    </a>
                    <a href="category_list.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-play-circle mr-2"></i>Categorie
                    </a>
                </div>
                
                <!-- Info utilisateur -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium"><?php echo htmlspecialchars($_SESSION['user_nom']) ?></p>
                        <p class="text-sm text-blue-200">Étudiant</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="../auth/logout.php" 
                       class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl p-8 shadow">
            <h2 class="text-3xl font-bold mb-2">Liste des Quiz</h2>
            <p class="text-indigo-100">Choisissez un quiz et commencez le test</p>
        </div>
    </section>

    <!-- QUIZ LIST -->
    <section class="max-w-7xl mx-auto px-6 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        

            <?php if (empty($quizzes)): ?>

                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-8 text-center">
                <i class="fas fa-clipboard-list text-5xl text-yellow-400 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun quiz disponible</h3>
                <p class="text-gray-600">Les enseignants préparent de nouveaux quiz.</p>
            </div>

            
            

            <?php else: ?>

                <?php foreach ($quizzes as $quiz) : ?>

                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                        <div class="h-2 bg-indigo-500"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($quiz['titre']); ?></h3>
                            <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($quiz['description']) ?></p>
                            <a href="#"
                                class="block text-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded-lg">
                                Commencer
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>


    </section>

</body>

</html>