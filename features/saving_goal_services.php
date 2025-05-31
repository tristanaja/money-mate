<?php
require_once __DIR__ . '/../includes/auth_process_essentials.php';

class saving_goal_services
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->createInitialSavingGoal();
    }

    private function createInitialSavingGoal()
    {
        if (!isset($_SESSION['user_id']))
            return false;

        // Prevent duplicate budget
        $check = $this->db->prepare("SELECT id FROM saving_goals WHERE user_id = ?");
        $check->bind_param("i", $_SESSION["user_id"]);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            return false; // Budget already exists
        }

        $stmt = $this->db->prepare("INSERT INTO saving_goals (user_id, amount, target_month, target_year) VALUES (?, ?, ?, ?)");
        $zero = 0.0;
        $currentMonth = date('n'); // Current month
        $currentYear = date('Y'); // Current year
        $stmt->bind_param("idii", $_SESSION["user_id"], $zero, $currentMonth, $currentYear);
        return $stmt->execute();
    }

    public function editSavingGoal($newAmount, $targetMonth, $targetYear)
    {
        if (!isset($_SESSION['user_id']))
            return false;

        // Validate inputs
        if (!is_numeric($newAmount) || $newAmount <= 0)
            return false;
        if (!is_numeric($targetMonth) || $targetMonth < 1 || $targetMonth > 12)
            return false;
        if (!is_numeric($targetYear) || $targetYear < 2000)
            return false;

        $status = 'NOT ACHIEVED';

        $stmt = $this->db->prepare("
        UPDATE saving_goals 
        SET amount = ?, target_month = ?, target_year = ? 
        WHERE user_id = ?
    ");
        $stmt->bind_param("diii", $newAmount, $targetMonth, $targetYear, $_SESSION['user_id']);

        return $stmt->execute();
    }


    public function getSavingGoal()
    {
        if (!isset($_SESSION['user_id']))
            return [];

        $stmt = $this->db->prepare("SELECT * FROM saving_goals WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }

    public function checkAndUpdateSavingGoalStatus()
    {
        if (!isset($_SESSION['user_id'])) return false;

        $userId = $_SESSION['user_id'];
        date_default_timezone_set('Asia/Jakarta');
        $today = new DateTime();
        $currentMonth = (int)$today->format('n');
        $currentYear = (int)$today->format('Y');

        // Get current saving goal
        $stmt = $this->db->prepare("SELECT id, amount, target_month, target_year FROM saving_goals WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $savingGoal = $result->fetch_assoc();

        if (!$savingGoal) return false;

        // Get current budget
        $budgetStmt = $this->db->prepare("SELECT amount FROM budgets WHERE user_id = ?");
        $budgetStmt->bind_param("i", $userId);
        $budgetStmt->execute();
        $budgetResult = $budgetStmt->get_result()->fetch_assoc();

        if (!$budgetResult) return false;

        $goalAmount = (float)$savingGoal['amount'];
        $budgetAmount = (float)$budgetResult['amount'];
        $targetMonth = (int)$savingGoal['target_month'];
        $targetYear = (int)$savingGoal['target_year'];

        // Determine status
        if ($currentYear < $targetYear || ($currentYear == $targetYear && $currentMonth < $targetMonth)) {
            $status = 'ON PROGRESS';
        } else {
            if ($budgetAmount > $goalAmount) {
                $status = 'BONUS';
            } elseif ($budgetAmount == $goalAmount) {
                $status = 'ACHIEVED';
            } else {
                $status = 'NOT ACHIEVED';
            }
        }

        // Update saving goal status
        $updateStmt = $this->db->prepare("UPDATE saving_goals SET status = ? WHERE id = ?");
        $updateStmt->bind_param("si", $status, $savingGoal['id']);
        return $updateStmt->execute();
    }
}
