<?php
require_once __DIR__ . '/../includes/auth_process_essentials.php';

class budget_services
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->createInitialBudget();
    }

    private function createInitialBudget()
    {
        if (!isset($_SESSION['user_id'])) return false;

        // Prevent duplicate budget
        $check = $this->db->prepare("SELECT id FROM budgets WHERE user_id = ?");
        $check->bind_param("i", $_SESSION["user_id"]);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            return false; // Budget already exists
        }

        $stmt = $this->db->prepare("INSERT INTO budgets (user_id, amount) VALUES (?, ?)");
        $zero = 0.0;
        $stmt->bind_param("id", $_SESSION["user_id"], $zero);
        return $stmt->execute();
    }

    public function addBudget($addAmount)
    {
        if (!isset($_SESSION['user_id'])) return false;
        if (!is_numeric($addAmount) || $addAmount <= 0) return false;

        $stmt = $this->db->prepare("UPDATE budgets SET amount = amount + ? WHERE user_id = ?");
        $stmt->bind_param("di", $addAmount, $_SESSION['user_id']);
        return $stmt->execute();
    }

    public function getBudgets()
    {
        if (!isset($_SESSION['user_id'])) return [];

        $stmt = $this->db->prepare("SELECT * FROM budgets WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }

    public function subtractBudget($subtractAmount)
    {
        if (!isset($_SESSION['user_id'])) return false;
        if (!is_numeric($subtractAmount) || $subtractAmount <= 0) return false;

        $checkStmt = $this->db->prepare("SELECT amount FROM budgets WHERE user_id = ?");
        $checkStmt->bind_param("i", $_SESSION['user_id']);
        $checkStmt->execute();
        $result = $checkStmt->get_result()->fetch_assoc();

        if (!$result || $result['amount'] < $subtractAmount) {
            return false; // Not enough budget
        }

        $stmt = $this->db->prepare("UPDATE budgets SET amount = amount - ? WHERE user_id = ?");
        $stmt->bind_param("di", $subtractAmount, $_SESSION['user_id']);
        return $stmt->execute();
    }
}
