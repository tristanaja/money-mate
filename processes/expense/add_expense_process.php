<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth_process_essentials.php';
require_once __DIR__ . '/../../includes/helper.php';
require_once __DIR__ . '/../../features/expense_services.php';
require_once __DIR__ . '/../../features/budget_services.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    Helper::redirect_with_error('../../index.php', 'Please log in first.');
}

// Get input
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$unitAmount = floatval($_POST['unit_amount'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);
$amount = $unitAmount * $quantity;
$categoryId = intval($_POST['category_id'] ?? 0);

// Validate input
if (
    empty($title) || strlen($title) < 3 || strlen($title) > 100 ||
    empty($description) || strlen($description) < 3 ||
    $amount <= 0 || $categoryId <= 0
) {
    Helper::redirect_with_error('../../index.php', 'Invalid expense data. Please check your input.');
}

// Initialize service
$db = (new Database())->connect();
$budgetService = new budget_services($db);

$expenseService = new expense_services($db, $budgetService);


// Attempt to add expense
$success = $expenseService->addExpense($amount, $categoryId, $title, $description, $quantity);

// Handle result
if ($success) {
    $_SESSION['success'] = 'Expense added successfully.';
} else {
    Helper::redirect_with_error('../../index.php', 'Failed to add expense.');
}

header("Location: ../../index.php");
exit();
