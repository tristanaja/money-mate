<?php
require_once "../includes/auth_process_essentials.php";
require_once "../includes/helper.php";

$db = (new Database())->connect();
$auth = new Auth_Services($db);
$helper = new Helper();

$username = $_REQUEST['username'] ?? '';
$email = $_REQUEST['email'] ?? '';
$password = $_REQUEST['password'] ?? '';

if (!preg_match('/^[a-zA-Z0-9_]{3,15}$/', $username)) {
    $helper->redirect_with_error('../pages/auth_pages/sign_up.php', 'Only letters, numbers, and underscores. with lenght of 3–15 chars');
}

if (empty($email) || empty($password)) {
    $helper->redirect_with_error('../pages/auth_pages/sign_up.php', 'All Fields Required.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $helper->redirect_with_error('../pages/auth_pages/sign_up.php', 'Invalid Email Format');
}

if (strlen($password) < 8) {
    $helper->redirect_with_error('../pages/auth_pages/sign_up.php', 'Password Must Contain 8 Characters');
}

if ($auth->register($username, $email, $password)) {
    unset($_SESSION['error']);
    header('Location: ../pages/auth_pages/sign_in.php');
    exit;
} else {
    $helper->redirect_with_error('../pages/auth_pages/sign_up.php', 'Registration Failed.');
}
