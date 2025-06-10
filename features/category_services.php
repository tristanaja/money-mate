<?php
require_once __DIR__ . '/../includes/auth_process_essentials.php';

class category_services
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->createInitialCategories();
    }

    private function createInitialCategories()
    {
        if (!isset($_SESSION['user_id'])) return false;

        // Prevent duplicate categories
        $check = $this->db->prepare("SELECT id FROM categories WHERE user_id = ?");
        $check->bind_param("i", $_SESSION["user_id"]);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            return false; // Categories already exist
        }

        // Insert default categories
        $stmt = $this->db->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
        $defaultCategories = ['Food', 'Transport', 'Entertainment', 'Utilities', 'Health'];

        foreach ($defaultCategories as $category) {
            $stmt->bind_param("is", $_SESSION["user_id"], $category);
            if (!$stmt->execute()) {
                return false; // Failed to insert category
            }
        }

        return true;
    }

    public function getCategories()
    {
        if (!isset($_SESSION['user_id'])) return [];

        $stmt = $this->db->prepare("SELECT * FROM categories WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }

    public function addCategory($categoryName)
    {
        if (!isset($_SESSION['user_id']) || empty($categoryName)) return false;

        // Validate category name
        if (strlen($categoryName) < 3 || strlen($categoryName) > 50) return false;

        // Check if category exists
        $check = $this->db->prepare("SELECT id FROM categories WHERE name = ? AND user_id = ?");
        $check->bind_param("si", $categoryName, $_SESSION['user_id']);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            return false; // Category does not exist
        }

        $stmt = $this->db->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['user_id'], $categoryName);
        return $stmt->execute();
    }

    public function editCategory($id, $newName)
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($id) || empty($newName)) return false;

        // Validate new category name
        if (strlen($newName) < 3 || strlen($newName) > 50) return false;

        // Check if category exists
        $check = $this->db->prepare("SELECT id FROM categories WHERE id = ? AND user_id = ?");
        $check->bind_param("ii", $id, $_SESSION['user_id']);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            return false; // Category does not exist
        }

        // Update the category name
        $stmt = $this->db->prepare("UPDATE categories SET name = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $newName, $id, $_SESSION['user_id']);
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($id)) return false;

        // Check if category exists
        $check = $this->db->prepare("SELECT id FROM categories WHERE id = ? AND user_id = ?");
        $check->bind_param("ii", $id, $_SESSION['user_id']);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            return false; // Category does not exist
        }

        // Delete the category
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $_SESSION['user_id']);
        return $stmt->execute();
    }

    public function getExpenseCount($id)
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($id)) return 0;

        // Check if category exists
        $check = $this->db->prepare("SELECT id FROM categories WHERE id = ? AND user_id = ?");
        $check->bind_param("ii", $id, $_SESSION['user_id']);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            return 0; // Category does not exist
        }

        // Count expenses in the category
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM expenses WHERE category_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $_SESSION['user_id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            return (int)$result['count'];
        }

        return 0;
    }

    public function getExpenseSum($id)
    {
        if (!isset($_SESSION['user_id']) || !is_numeric($id)) return 0.0;

        // Check if category exists
        $check = $this->db->prepare("SELECT id FROM categories WHERE id = ? AND user_id = ?");
        $check->bind_param("ii", $id, $_SESSION['user_id']);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            return 0.0; // Category does not exist
        }

        // Sum expenses in the category
        $stmt = $this->db->prepare("SELECT SUM(amount) as total FROM expenses WHERE category_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $_SESSION['user_id']);

        if ($stmt->execute()) {
            $result = $stmt->get_result()->fetch_assoc();
            return (float)$result['total'];
        }

        return 0.0;
    }

    public function getIdByCategory($name)
    {
        if (!isset($_SESSION['user_id'])) return null;

        // Check if category exists
        $check = $this->db->prepare("SELECT id FROM categories WHERE name = ? AND user_id = ?");
        $check->bind_param("ii", $name, $_SESSION['user_id']);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            return null; // Category does not exist
        }

        // Get the category details
        $stmt = $this->db->prepare("SELECT id FROM categories WHERE name = ? AND user_id = ?");
        $stmt->bind_param("si", $name, $_SESSION['user_id']);

        if ($stmt->execute()) {
            return $stmt->get_result()->fetch_assoc();
        }

        return null;
    }
}
