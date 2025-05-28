<?php
require_once "../includes/auth_process_essentials.php";

$db = (new Database())->connect();
$auth = new Auth_Services($db);

$email = $_REQUEST['email'] ?? "";
$password = $_REQUEST['password'] ?? "";

if (empty($email) || empty($password)) {
    $_SESSION['error'] = 'All Fields Required.';
    header('Location: ../pages/auth_pages/sign_in.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid Email Format';
    header('Location: ../pages/auth_pages/sign_in.php');
    exit;
}

if (strlen($password) < 8) {
    $_SESSION['error'] = 'Password Must Contain 8 Characters';
    header('Location: ../pages/auth_pages/sign_in.php');
    exit;
}

if ($auth->login($email, $password)) {
    unset($_SESSION['error']);
    header('Location: ../index.php');
    exit;
} else {
    $_SESSION['error'] = 'Invalid Email or Password';
    header('Location: ../pages/auth_pages/sign_in.php');
    exit;
}
