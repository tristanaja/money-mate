<?php
session_start();

require_once __DIR__ . '/../../.config/session.php';
require_once __DIR__ . '/../../features/saving_goal_services.php';
require_once __DIR__ . '/../../includes/helper.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    Helper::redirect_with_error('../../index.php', 'Please log in first.');
}

// Get and sanitize inputs
$amount = $_POST['amount'] ?? null;
$targetMonth = $_POST['target_month'] ?? null;
$targetYear = $_POST['target_year'] ?? null;

// Validate inputs
if (!$amount || !$targetMonth || !$targetYear) {
    Helper::redirect_with_error('../../index.php', 'All fields are required.');
}

if (
    !is_numeric($amount) || $amount <= 0 ||
    !is_numeric($targetMonth) || $targetMonth < 1 || $targetMonth > 12 ||
    !is_numeric($targetYear) || $targetYear < date('Y') || $targetYear > date('Y') + 10
) {
    Helper::redirect_with_error('../../index.php', 'Invalid input values.');
}

// Process update
$db = (new Database())->connect();
$savingGoalService = new saving_goal_services($db);

$success = $savingGoalService->editSavingGoal(floatval($amount), intval($targetMonth), intval($targetYear));

// Set feedback and redirect
if ($success) {
    $_SESSION['success'] = 'Saving goal updated successfully.';
} else {
    Helper::redirect_with_error('../../index.php', 'Failed to update saving goal.');
}

header('Location: ../../index.php');
exit();
