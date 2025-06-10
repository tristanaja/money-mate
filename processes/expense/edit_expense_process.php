<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth_process_essentials.php';
require_once __DIR__ . '/../../features/expense_services.php';
require_once __DIR__ . '/../../features/budget_services.php';

$db = (new Database())->connect();
$budgetService = new budget_services($db);
$expenseService = new expense_services($db, $budgetService);

// Validate POST inputs
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['expense_id'], $_POST['title'], $_POST['description'], $_POST['unit_amount'], $_POST['quantity'], $_POST['category_id'])
) {
    $expenseId = (int) $_POST['expense_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $unitAmount = floatval($_POST['unit_amount']);
    $quantity = intval($_POST['quantity']);
    $categoryId = intval($_POST['category_id']);

    // Recalculate total amount
    $newAmount = $unitAmount * $quantity;

    // Attempt update
    $success = $expenseService->updateExpense($expenseId, $newAmount, $categoryId, $title, $description, $quantity);

    if ($success) {
        $_SESSION['message'] = 'Expense updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update expense. Please try again.';
    }
} else {
    $_SESSION['error'] = 'Invalid form data.';
}

// Redirect back to the previous page
header('Location: ../../index.php');
exit;
