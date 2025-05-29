<?php
require_once __DIR__ . "/../includes/auth_process_essentials.php";

class Auth_Services
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($username, $email, $password)
    {
        $checkStmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $_SESSION['error'] = 'Email Already Registered';
            header('Location: ../pages/auth_pages/sign_up.php');
            exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password)
    {
        $stmt = $this->db->prepare("SELECT id, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $id = 0;
            $hash = "";
            $stmt->bind_result($id, $hash);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION["user_id"] = $id;
                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
    }

    public function getUsername()
    {
        if (isset($_SESSION["user_id"])) {
            $usernameUsed = "";
            $stmt = $this->db->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION["user_id"]);
            $stmt->execute();
            $stmt->bind_result($usernameUsed);
            $stmt->fetch();
            return $usernameUsed;
        }
        return "User";
    }
}
