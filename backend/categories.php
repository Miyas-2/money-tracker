<?php
class Categories
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function addCategory($user_id, $name, $type)
    {
        // Validate inputs
        if (empty($name) || !in_array($type, ['Income', 'Expense'])) {
            error_log("Invalid category data: name - $name, type - $type");
            return false;
        }

        $query = "INSERT INTO categories (user_id, name, type) VALUES (?, ?, ?)";

        try {
            $stmt = $this->conn->prepare($query);

            if ($stmt === false) {
                error_log("Prepare failed: " . $this->conn->error);
                return false;
            }

            $stmt->bind_param('iss', $user_id, $name, $type);

            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Execute failed: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in addCategory: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
    


    public function getCategoriesByUser ($user_id)
    {
        $query = "SELECT * FROM categories WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getIncomeCategoriesByUser ($user_id) {
        $query = "SELECT category_id, name FROM categories WHERE user_id = ? AND type = 'Income'";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param('i', $user_id);
        
        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return [];
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
 
    public function getExpenseCategoriesByUser ($user_id)
    {
        $query = "SELECT category_id, name FROM categories WHERE user_id = ? AND type = 'Expense'";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param('i', $user_id);
        
        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return [];
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Edit Category
    public function editCategory($category_id, $name, $type)
    {
        // Validate inputs
        if (empty($name) || !in_array($type, ['Income', 'Expense'])) {
            error_log("Invalid category data: name - $name, type - $type");
            return false;
        }

        $query = "UPDATE categories SET name = ?, type = ? WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param('ssi', $name, $type, $category_id);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error executing statement: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in editCategory: " . $e->getMessage());
            return false;
        }
    }

    // Delete Category
    public function deleteCategory($category_id)
    {
        $query = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param('i', $category_id);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error executing statement: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in deleteCategory: " . $e->getMessage());
            return false;
        }
    }
}
?>