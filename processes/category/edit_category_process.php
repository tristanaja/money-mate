<?php
require_once __DIR__ . '/../../.config/session.php';
require_once __DIR__ . '/../../features/category_services.php';
require_once __DIR__ . '/../../includes/helper.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    Helper::redirect_with_error('../../index.php', 'Please log in first.');
}

// Get and sanitize input
$categoryId = $_POST['category_id'] ?? null;
$categoryName = trim($_POST['category_name'] ?? '');

// Validate input
if (!$categoryId || !$categoryName) {
    Helper::redirect_with_error('../../pages/category_page/category_dashboard.php', 'All fields are required.');
}

if (!is_numeric($categoryId) || strlen($categoryName) < 3 || strlen($categoryName) > 50) {
    Helper::redirect_with_error('../../pages/category_page/category_dashboard.php', 'Invalid input values.');
}

// Process update
$db = (new Database())->connect();
$categoryService = new category_services($db);

$success = $categoryService->editCategory((int)$categoryId, $categoryName);

// Set feedback and redirect
if ($success) {
    $_SESSION['success'] = 'Category updated successfully.';
} else {
    Helper::redirect_with_error('../../pages/category_page/category_dashboard.php', 'Failed to update category.');
}

header('Location: ../../pages/category_page/category_dashboard.php');
exit();
