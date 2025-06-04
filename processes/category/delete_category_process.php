<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth_process_essentials.php';
require_once __DIR__ . '/../../features/category_services.php';
require_once __DIR__ . '/../../includes/helper.php';

// Validate if user is logged in
if (!isset($_SESSION['user_id'])) {
    Helper::redirect_with_error('../../index.php', 'Please log in first.');
}

// Validate category ID
$categoryId = $_POST['category_id'] ?? null;

if (!$categoryId || !is_numeric($categoryId)) {
    Helper::redirect_with_error('../../pages/category_page/category_dashboard.php', 'Invalid category ID.');
}

// Initialize service
$db = (new Database())->connect();
$categoryService = new category_services($db);

// Attempt to delete category
$deleted = $categoryService->deleteCategory((int) $categoryId);

if ($deleted) {
    $_SESSION['success'] = "Category deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete category. Please try again.";
}

// Redirect back to category dashboard
header('Location: ../../pages/category_page/category_dashboard.php');
exit;
