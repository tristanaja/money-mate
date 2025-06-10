<?php
require_once __DIR__ . '/../../.config/session.php';
require_once __DIR__ . '/../../features/category_services.php';
require_once __DIR__ . '/../../includes/helper.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    Helper::redirect_with_error('../../index.php', 'Please log in first.');
}

// Get input
$categoryName = trim($_POST['category_name'] ?? '');

// Validate input
if (empty($categoryName) || strlen($categoryName) < 3 || strlen($categoryName) > 50) {
    Helper::redirect_with_error('../../pages/category_page/category_dashboard.php', 'Category name must be between 3 and 50 characters.');
}

// Init service
$db = (new Database())->connect();
$categoryService = new category_services($db);

// Try to add category
$success = $categoryService->addCategory($categoryName);

// Handle result
if ($success) {
    $_SESSION['success'] = 'Category added successfully.';
} else {
    Helper::redirect_with_error('../../pages/category_page/category_dashboard.php', 'Failed to add category. It might already exist.');
}

header("Location: ../../pages/category_page/category_dashboard.php");
exit();
