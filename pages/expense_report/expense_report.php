<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth_process_essentials.php';
require_once __DIR__ . '/../../features/budget_services.php';
require_once __DIR__ . '/../../features/saving_goal_services.php';

$db = (new Database())->connect();
new saving_goal_services($db)->checkAndUpdateSavingGoalStatus();

$savingGoalData = (new saving_goal_services($db))->getsavingGoal();
$currentBudget = (new budget_services($db))->getBudgets()[0]['amount'] ?? 0.0;
$currentSavingGoalAmount = !empty($savingGoalData) ? $savingGoalData[0]['amount'] : 0.0;
$currentSavingGoalStatus = !empty($savingGoalData) ? $savingGoalData[0]['status'] : 'NOT ACHIEVED';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?= $currentSavingGoalAmount ?> <?= $currentSavingGoalStatus ?> <?= $currentBudget ?>
</body>

</html>