<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Security.php';
require_once '../../classes/Category.php';
require_once '../../classes/Quiz.php';
require_once '../../classes/studentClasses/categoryStudent.php';

$categoryStudent = new CategoryStudent();
$categories = $categoryStudent->getAllCategory(4);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Liste des Quiz - QuizMaster</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * { font-family: 'Inter', sans-serif; }

    .card-hover:hover { transform: translateY(-5px); transition: all 0.3s ease; }
    .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
  </style>
</head>

<body class="bg-gray-50 min-h-screen">

  <!-- NAVBAR -->
  <nav class="gradient-primary text-white shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-3">
          <div class="bg-white/20 p-2 rounded-lg"><i class="fas fa-graduation-cap text-xl"></i></div>
          <div>
            <h1 class="text-xl font-bold">QuizMaster</h1>
            <p class="text-sm text-blue-200">Espace Étudiant</p>
          </div>
        </div>

        <div class="hidden md:flex items-center space-x-8">
          <a href="dashboard.php" class="font-semibold hover:text-blue-200 transition"><i class="fas fa-home mr-2"></i>Tableau de Bord</a>
          <a href="categories.php" class="hover:text-blue-200 transition"><i class="fas fa-folder mr-2"></i>Catégories</a>
          <a href="history.php" class="hover:text-blue-200 transition"><i class="fas fa-history mr-2"></i>Historique</a>
          <a href="category_list.php" class="hover:text-blue-200 transition"><i class="fas fa-play-circle mr-2"></i>Categorie</a>
        </div>

        <div class="flex items-center space-x-4">
          <div class="text-right hidden md:block">
            <p class="font-medium"><?php echo htmlspecialchars($_SESSION['user_nom'] ?? 'Étudiant') ?></p>
            <p class="text-sm text-blue-200">Étudiant</p>
          </div>
          <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <i class="fas fa-user"></i>
          </div>
          <a href="../auth/logout.php" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- MAIN -->
  <main class="max-w-7xl mx-auto px-4 py-10">

    <!-- HEADER -->
    <div class="gradient-primary text-white rounded-2xl p-8 mb-10 shadow-lg">
      <h1 class="text-3xl font-bold mb-2">Liste des Quiz</h1>
      <p class="text-blue-100">Choisissez un quiz et commencez le test</p>
    </div>

    <!-- FILTER -->
    <div class="flex flex-col md:flex-row gap-4 mb-8">
      <input type="text" id="searchInput" placeholder="Rechercher un quiz..."
        class="flex-1 px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <!-- QUIZ CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

      <?php if(empty($categories)): ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-8 text-center col-span-3">
          <i class="fas fa-clipboard-list text-5xl text-yellow-400 mb-4"></i>
          <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun quiz disponible</h3>
          <p class="text-gray-600">Les enseignants préparent de nouveaux quiz.</p>
        </div>
      <?php else: ?>
        <?php foreach($categories as $categorie): ?>
          <div class="quizCards bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition hover:-translate-y-1 flex flex-col">
            <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            <div class="p-6 flex flex-col flex-1">
              <h3 class="quiz-title text-xl font-bold text-gray-800 mb-3"><?php echo htmlspecialchars($categorie['nom']); ?></h3>
              <div class="text-sm text-blue-600 font-semibold mb-2">
                <i class="fas fa-layer-group mr-1"></i>
                <?php echo htmlspecialchars($categorie['quiz_count']); ?> Quiz
              </div>
              <p class="text-gray-600 mb-4 text-sm"><?php echo htmlspecialchars($categorie['description'] ?? 'Testez vos connaissances'); ?></p>
              <div class="flex items-center text-sm text-gray-500 mb-6">
                <i class="far fa-calendar-alt mr-2"></i>
                <span><?php echo htmlspecialchars($categorie['created_at'] ?? ''); ?></span>
              </div>
              <div class="mt-auto flex gap-2">
                <a href="quiz_list.php?id=<?php echo $categorie['id']; ?>" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg text-center transition">
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

  </main>

  <!-- JS Filter -->
  <script>
    const searchInput = document.getElementById("searchInput")
    const quizCards = document.querySelectorAll(".quizCards")

    searchInput.addEventListener("keyup", function() {
      const value = this.value.toLowerCase()
      quizCards.forEach(card => {
        const title = card.querySelector(".quiz-title").innerText.toLowerCase()
        card.style.display = title.includes(value) ? "" : "none"
      })
    })
  </script>

</body>
</html>
