<?php
require_once __DIR__ . '/session.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: pages/auth_pages/sign_in.php');
    exit();
}
