<?php
require_once "../includes/auth_process_essentials.php";
require_once "../includes/helper.php";

$db = (new Database())->connect();
$auth = new Auth_Services($db);

$email = $_REQUEST['email'] ?? "";
$password = $_REQUEST['password'] ?? "";

if (empty($email) || empty($password)) {
    Helper::redirect_with_error('../pages/auth_pages/sign_in.php', 'All Fields Required.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Helper::redirect_with_error('../pages/auth_pages/sign_in.php', 'Invalid Email Format');
}

if (strlen($password) < 8) {
    Helper::redirect_with_error('../pages/auth_pages/sign_in.php', 'Password Must Contain 8 Characters');
}

if ($auth->login($email, $password)) {
    unset($_SESSION['error']);
    header('Location: ../index.php');
    exit;
} else {
    Helper::redirect_with_error('../pages/auth_pages/sign_in.php', 'Invalid Email or Password');
}
