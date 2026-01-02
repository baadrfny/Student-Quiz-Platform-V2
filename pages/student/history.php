<?php
require_once '../../config/database.php';
require_once '../../classes/Database.php';
require_once '../../classes/Security.php';


// Security check: Ensure student is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$db = Database::getInstance();
$conn = $db->getConnection();

try {
    // SQL Query using JOIN to get Quiz Title and Results
    $query = "SELECT r.score, r.total_questions, r.created_at, q.titre as quiz_title 
              FROM results r 
              JOIN quiz q ON r.quiz_id = q.id 
              WHERE r.etudiant_id = :student_id 
              ORDER BY r.created_at DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([':student_id' => $student_id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Quiz History</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="max-w-5xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">Quiz History</h1>
            <a href="dashboard.php" class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                Back to Dashboard
            </a>
        </div>

        <?php if (empty($results)): ?>
            <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-200">
                <p class="text-gray-500 text-lg">You haven't taken any quizzes yet.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quiz Name</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Date Taken</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($results as $row): ?>
                            <?php 
                                $percentage = ($row['score'] / $row['total_questions']) * 100;
                                $passed = $percentage >= 50;
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5">
                                    <span class="text-sm font-bold text-gray-900"><?= htmlspecialchars($row['quiz_title']) ?></span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="text-sm font-medium text-gray-700">
                                        <?= $row['score'] ?> / <?= $row['total_questions'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $passed ? 'Passed' : 'Failed' ?> (<?= round($percentage) ?>%)
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right text-sm text-gray-500 italic">
                                    <?= date('M d, Y - H:i', strtotime($row['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>