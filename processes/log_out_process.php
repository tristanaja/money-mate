<?php
require_once "../includes/auth_process_essentials.php";

$db = (new Database())->connect();
$auth = new Auth_Services($db);

$auth->logout();

session_unset();

header("Location: ../pages/auth_pages/sign_in.php");
exit;
