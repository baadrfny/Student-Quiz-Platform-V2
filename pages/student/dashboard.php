<?php 
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Security.php';
require_once '../../classes/Category.php';
require_once '../../classes/Quiz.php';
require_once '../../classes/studentClasses/getQuiz.php';
require_once '../../classes/studentClasses/categoryStudent.php';


echo "<div style='background:yellow; padding:10px; margin:10px;'>";
echo "<h3>Debug Session:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "</div>";



$categoryStudent = new CategoryStudent();
$categoies = $categoryStudent->getAllCategory(4);

$student_id = $_SESSION['user_id'] ?? 0;
$student_name = $_SESSION['user_nom'] ?? 'Étudiant';

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Étudiant - QuizMaster</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
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
<body class="bg-gray-50 min-h-screen">
    
    <!-- ========== NAVIGATION ========== -->
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
    
    <!-- ========== MAIN CONTENT ========== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Section Bienvenue -->
        <div class="gradient-primary text-white rounded-2xl p-8 shadow-xl mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Bonjour, <?php echo htmlspecialchars($_SESSION['user_nom']) ?>👋</h1>
                    <p class="text-blue-100">Bienvenue sur votre espace personnel. Prêt à apprendre ?</p>
                </div>
                <div class="mt-4 md:mt-0 bg-white/20 p-4 rounded-xl">
                    <p class="text-sm">Membre depuis</p>
                    <p class="font-bold">15 Mars 2024</p>
                
                </div>
            </div>
        </div>
        
        <!-- Cartes Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Carte Quiz Complétés -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 text-sm">Quiz Complétés</p>
                        <h3 class="text-2xl font-bold text-gray-800">12</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-check-circle text-2xl text-blue-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">+2 cette semaine</p>
            </div>
            
            <!-- Carte Score Moyen -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 text-sm">Score Moyen</p>
                        <h3 class="text-2xl font-bold text-gray-800">85%</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-2xl text-green-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">+5% depuis le mois dernier</p>
            </div>
            
            <!-- Carte Temps d'Étude -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-purple-500">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 text-sm">Temps d'Étude</p>
                        <h3 class="text-2xl font-bold text-gray-800">24h</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-clock text-2xl text-purple-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">Cette semaine</p>
            </div>
        </div>
        
        <!-- Actions Rapides -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Actions Rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            
            <!-- Carte Catégories -->
            <a href="categories.php" class="card-hover">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition">
                    <div class="bg-blue-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-folder-open text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Catégories</h3>
                    <p class="text-gray-600 text-sm">Parcourir les quiz par matière</p>
                </div>
            </a>
            
            <!-- Carte Nouveau Quiz -->
            <a href="quiz_list.php" class="card-hover">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition">
                    <div class="bg-green-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-play-circle text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Nouveau Quiz</h3>
                    <p class="text-gray-600 text-sm">Commencer un test immédiatement</p>
                </div>
            </a>
            
            <!-- Carte Progression -->
            <a href="history.php" class="card-hover">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition">
                    <div class="bg-purple-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Progression</h3>
                    <p class="text-gray-600 text-sm">Voir votre évolution</p>
                </div>
            </a>
            
            <!-- Carte Profil -->
            <a href="#" class="card-hover">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition">
                    <div class="bg-yellow-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-circle text-3xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Profil</h3>
                    <p class="text-gray-600 text-sm">Gérer vos informations</p>
                </div>
            </a>
        </div>
        
        <!-- Section Activité Récente -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Activité Récente</h2>
                <a href="history.php" class="text-blue-600 hover:text-blue-800 font-medium">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="space-y-4">
                <!-- Activité 1 -->
                <div class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-check text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">Quiz de Mathématiques complété</h4>
                        <p class="text-gray-600 text-sm">Score: 90% • Il y a 2 heures</p>
                    </div>
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        Excellent
                    </div>
                </div>
                
                <!-- Activité 2 -->
                <div class="flex items-center p-4 bg-green-50 rounded-lg border border-green-100">
                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-medal text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">Nouveau record personnel !</h4>
                        <p class="text-gray-600 text-sm">95% en Sciences • Hier</p>
                    </div>
                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        Record
                    </div>
                </div>
                
                <!-- Activité 3 -->
                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="bg-gray-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-book text-gray-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">Quiz de Français commencé</h4>
                        <p class="text-gray-600 text-sm">En cours • 15 questions restantes</p>
                    </div>
                    <div class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                        En cours
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quiz Recommandés -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Quiz Recommandés pour Vous</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <?php if (empty($categoies)): ?>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-8 text-center">
                <i class="fas fa-clipboard-list text-5xl text-yellow-400 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun categorie disponible</h3>
                <p class="text-gray-600">Les enseignants préparent de nouveaux category.</p>
            </div>
        <?php else: ?>

                <?php foreach ($categoies as $category): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition hover:-translate-y-1">
                        <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">
                                <?php echo htmlspecialchars($category['nom']); ?>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 text-sm">
                                <?php 
                                $description = $category['description'] ?? 'Testez vos connaissances';
                                echo htmlspecialchars(substr($description,0,80));
                                if (strlen($description) > 80) echo '...';
                                ?>
                            </p>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-6">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>
                                    <?php echo date('d/m/Y', strtotime($category['created_at'])); ?>
                                </span>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="quiz_list.php?id=<?php echo $category['id']; ?>" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition text-center">
                                    Démarrer
                                </a>
                                <button class="flex-1 border border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-2 rounded-lg transition">
                                    Plus d'info
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </main>
    
    <!-- ========== FOOTER ========== -->
    <footer class="mt-12 bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Colonne 1 -->
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-graduation-cap text-2xl mr-3"></i>
                        <span class="text-xl font-bold">QuizMaster</span>
                    </div>
                    <p class="text-gray-400">Plateforme d'apprentissage interactive pour étudiants.</p>
                </div>
                
                <!-- Colonne 2 -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="dashboard.php" class="text-gray-400 hover:text-white">Tableau de Bord</a></li>
                        <li><a href="categories.php" class="text-gray-400 hover:text-white">Catégories</a></li>
                        <li><a href="quiz_list.php" class="text-gray-400 hover:text-white">Quiz</a></li>
                        <li><a href="history.php" class="text-gray-400 hover:text-white">Historique</a></li>
                    </ul>
                </div>
                
                <!-- Colonne 3 -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Colonne 4 -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Politique de confidentialité</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 QuizMaster. Tous droits réservés.</p>
                <p class="mt-2">Projet éducatif - Version 2.0</p>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript pour interactivité -->
    <script>
        // Exemple simple d'interaction
        document.addEventListener('DOMContentLoaded', function() {
            // Animation au survol des cartes
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Notification de bienvenue
            setTimeout(() => {
                console.log('Bienvenue sur QuizMaster !');
            }, 1000);
        });
    </script>
</body>
</html>