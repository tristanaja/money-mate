<?php
require_once __DIR__ . '/../includes/auth_process_essentials.php';

class expense_services
{
    private $db;
    private $budgetService;

    public function __construct($db, $budgetService)
    {
        $this->db = $db;
        $this->budgetService = $budgetService;
    }

    public function addExpense($amount, $categoryId, $title, $description, $quantity)
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($amount) || $amount <= 0 || empty($categoryId)) {
            return false;
        }

        if (!$this->budgetService->subtractBudget($amount)) {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO expenses (user_id, amount, category_id, title, description, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("idsssi", $_SESSION["user_id"], $amount, $categoryId, $title, $description, $quantity);

        return $stmt->execute();
    }

    public function getExpenses()
    {
        if (!isset($_SESSION['user_id'])) return [];

        $stmt = $this->db->prepare("SELECT * FROM expenses WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }

    public function deleteExpense($expenseId)
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($expenseId)) {
            return false;
        }

        $substmt = $this->db->prepare('SELECT amount FROM expenses WHERE id = ? AND user_id = ?');
        $substmt->bind_param('ii', $expenseId, $_SESSION['user_id']);
        $substmt->execute();
        $result = $substmt->get_result();
        if ($result->num_rows === 0) {
            return false; // Expense not found
        }
        $expense = $result->fetch_assoc();
        $amount = $expense['amount'];

        if (!$this->budgetService->addBudget($amount)) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $expenseId, $_SESSION['user_id']);

        return $stmt->execute();
    }

    public function updateExpense($expenseId, $newAmount, $categoryId, $title, $description, $quantity)
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($expenseId) || !is_numeric($newAmount) || $newAmount <= 0 || empty($categoryId)) {
            return false;
        }

        $substmt = $this->db->prepare('SELECT amount FROM expenses WHERE id = ? AND user_id = ?');
        $substmt->bind_param('ii', $expenseId, $_SESSION['user_id']);
        $substmt->execute();
        $result = $substmt->get_result();
        if ($result->num_rows === 0) {
            return false; // Expense not found
        }
        $expense = $result->fetch_assoc();
        $oldAmount = $expense['amount'];
        $amountDifference = $newAmount - $oldAmount;
        if ($amountDifference < 0) {
            // If the new amount is less, add the difference back to the budget
            if (!$this->budgetService->addBudget(-$amountDifference)) {
                return false;
            }
        } elseif ($amountDifference > 0) {
            // If the new amount is more, subtract the difference from the budget
            if (!$this->budgetService->subtractBudget($amountDifference)) {
                return false;
            }
        }

        $stmt = $this->db->prepare("UPDATE expenses SET amount = ?, title = ?, description = ?, quantity = ?, category_id = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("dssiiii", $newAmount, $title, $description, $quantity, $categoryId, $expenseId, $_SESSION['user_id']);
        if (!$stmt) {
            return false; // Prepare failed
        }
        if ($stmt->error) {
            return false; // Error in statement
        }
        $stmt->bind_param("dssiiii", $newAmount, $title, $description, $quantity, $categoryId, $expenseId, $_SESSION['user_id']);
        if (!$stmt->execute()) {
            return false; // Execution failed
        }


        return $stmt->execute();
    }

    public function getExpenseSum()
    {
        if (!isset($_SESSION['user_id'])) return 0.0;

        $stmt = $this->db->prepare("SELECT SUM(amount) as total FROM expenses WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            return (float)$result['total'];
        }

        return 0.0;
    }
}
