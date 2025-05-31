<?php
session_start();
require_once __DIR__ . '/../../.config/session.php';
require_once __DIR__ . '/../../features/budget_services.php';
require_once __DIR__ . '/../../includes/helper.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    Helper::redirect_with_error('../../pages/sign_in.php', 'Please log in first.');
}

// Get input
$amount = $_POST['amount'] ?? null;
$action = $_POST['action'] ?? null;

// Validate input
if (!$amount || !$action || !is_numeric($amount)) {
    Helper::redirect_with_error('../../index.php', 'Invalid input.');
}

$amount = floatval($amount);
$db = (new Database())->connect();
$budgetService = new budget_services($db);

// Process action
switch ($action) {
    case 'add':
        $success = $budgetService->addBudget($amount);
        break;
    case 'subtract':
        $success = $budgetService->subtractBudget($amount);
        break;
    default:
        Helper::redirect_with_error('../../index.php', 'Invalid action.');
}

// Handle result
if ($success) {
    $_SESSION['success'] = 'Budget updated successfully.';
} else {
    Helper::redirect_with_error('../../index.php', 'Failed to update budget. Check your balance.');
}

header("Location: ../../index.php");
exit();
