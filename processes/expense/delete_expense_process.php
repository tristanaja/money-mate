<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth_process_essentials.php';
require_once __DIR__ . '/../../features/expense_services.php';
require_once __DIR__ . '/../../features/budget_services.php';
require_once __DIR__ . '/../../includes/helper.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    Helper::redirect_with_error('../../index.php', 'Please log in first.');
}

// Validate expense ID
$expenseId = $_POST['id'] ?? null;
if (!$expenseId || !is_numeric($expenseId)) {
    Helper::redirect_with_error('../../index.php', 'Invalid expense ID.');
}

// Connect to database and initialize services
$db = (new Database())->connect();
$budgetService = new budget_services($db);
$expenseService = new expense_services($db, $budgetService);

// Attempt to delete expense
$deleted = $expenseService->deleteExpense((int) $expenseId);

if ($deleted) {
    $_SESSION['success'] = "Expense deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete expense. Please try again.";
}

// Redirect back to homepage
header('Location: ../../index.php');
exit;
