<?php
require_once "../includes/auth_process_essentials.php";

$db = (new Database())->connect();
$auth = new Auth_Services($db);

$username = $_REQUEST['username'] ?? '';
$email = $_REQUEST['email'] ?? '';
$password = $_REQUEST['password'] ?? '';

if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    $_SESSION['error'] = 'Only letters, numbers, and underscores. 3–20 chars';
    header('Location: ../pages/auth_pages/sign_up.php');
    exit;
}

if (empty($email) || empty($password)) {
    $_SESSION['error'] = 'All Fields Required.';
    header('Location: ../pages/auth_pages/sign_up.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid Email Format';
    header('Location: ../pages/auth_pages/sign_up.php');
    exit;
}

if (strlen($password) < 8) {
    $_SESSION['error'] = 'Password Must Contain 8 Characters';
    header('Location: ../pages/auth_pages/sign_up.php');
    exit;
}

if ($auth->register($username, $email, $password)) {
    unset($_SESSION['error']);
    header('Location: ../pages/auth_pages/sign_in.php');
    exit;
} else {
    $_SESSION['error'] = 'Registration Failed.';
    header('Location: ../pages/auth_pages/sign_up.php');
    exit;
}
