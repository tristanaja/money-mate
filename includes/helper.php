<?php
require_once __DIR__ . '/../.config/session.php';

class Helper
{
    public static function redirect_with_error($url, $message)
    {
        $_SESSION['error'] = $message;
        header("Location: $url");
        exit();
    }
    public static function redirect_with_success($url, $message)
    {
        $_SESSION['success'] = $message;
        header("Location: $url");
        exit();
    }
}
