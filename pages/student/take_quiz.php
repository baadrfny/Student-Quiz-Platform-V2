<?php

require_once '../../classes/Database.php';
require_once '../../classes/Security.php';
require_once '../../classes/Category.php';
require_once '../../classes/Quiz.php';
require_once 'C:\laragon\www\Student-Quiz-Platform-V2\classes\studentClasses\ShowCategory.php';
require_once "C:\laragon\www\Student-Quiz-Platform-V2\classes\studentClasses\ShowQuestion.php";

$showQues = new ShowQuestion();
$questions = $showQues->getAllQuestion();




?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Quiz Questions</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-4xl mx-auto py-10 px-4">

  <h1 class="text-3xl font-bold mb-8 text-center">Quiz Questions</h1>

  <?php if (empty($questions)): ?>
    <div class="bg-yellow-100 text-yellow-700 p-6 rounded-lg text-center">
      Aucune question disponible pour ce quiz
    </div>
  <?php else: ?>

    <?php foreach ($questions as $index => $q): ?>
      <div class="bg-white rounded-xl shadow p-6 mb-6">

        <!-- Question -->
        <h2 class="font-semibold text-lg mb-4">
          <?php echo ($index + 1) . ". " . htmlspecialchars($q['question']); ?>
        </h2>

        <!-- Options -->
        <div class="space-y-3">

          <label class="block border rounded-lg p-3 hover:bg-indigo-50 cursor-pointer">
            <input type="radio" name="question_<?php echo $q['id']; ?>" class="mr-2">
            <?php echo htmlspecialchars($q['option1']); ?>
          </label>

          <label class="block border rounded-lg p-3 hover:bg-indigo-50 cursor-pointer">
            <input type="radio" name="question_<?php echo $q['id']; ?>" class="mr-2">
            <?php echo htmlspecialchars($q['option2']); ?>
          </label>

          <label class="block border rounded-lg p-3 hover:bg-indigo-50 cursor-pointer">
            <input type="radio" name="question_<?php echo $q['id']; ?>" class="mr-2">
            <?php echo htmlspecialchars($q['option3']); ?>
          </label>

          <label class="block border rounded-lg p-3 hover:bg-indigo-50 cursor-pointer">
            <input type="radio" name="question_<?php echo $q['id']; ?>" class="mr-2">
            <?php echo htmlspecialchars($q['option4']); ?>
          </label>

        </div>

      </div>
    <?php endforeach; ?>

    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg">
      Submit Quiz
    </button>

  <?php endif; ?>

</div>

</body>
</html>
