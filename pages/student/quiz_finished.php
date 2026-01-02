<?php
$score = $_GET['score'] ?? 0;
$total = $_GET['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Quiz Finished</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center">
    <h2 class="text-2xl font-bold mb-4">Quiz Finished!</h2>
    <p class="text-lg mb-4">Your Score: <?= $score ?> / <?= $total ?></p>
    <a href="dashboard.php" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Back to Dashboard</a>
</div>

</body>
</html>
