<?php
class Expense
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create (Add) Expense
    public function addExpense($user_id, $amount, $category_id, $date, $description)
    {
        // Additional input validation
        if (!is_numeric($amount) || $amount <= 0) {
            error_log("Invalid expense amount: $amount");
            return false;
        }

        $query = "INSERT INTO expense (user_id, amount, category_id, date, description) VALUES (?, ?, ?, ?, ?)";

        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Prepare failed: " . $this->conn->error);
                return false;
            }

            // Ensure description is a string or null
            $description = $description ? (string) $description : null;

            // Correct bind_param types
            $stmt->bind_param('idiss', $user_id, $amount, $category_id, $date, $description);

            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Execute failed: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in addExpense: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Read (Get) Expenses by User
    public function getExpensesByUser($user_id)
    {
        $query = "SELECT expense.*, categories.name AS category_name
                  FROM expense
                  JOIN categories ON expense.category_id = categories.category_id
                  WHERE expense.user_id = ?
                  ORDER BY expense.date DESC";


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

    // Edit Expense
    public function editExpense($expense_id, $amount, $category_id, $date, $description)
    {
        if (!is_numeric($amount) || $amount <= 0) {
            error_log("Invalid expense amount: $amount");
            return false;
        }

        // Format the amount to two decimal places
        $amount = number_format((float) $amount, 2, '.', '');

        $query = "UPDATE expense SET amount = ?, category_id = ?, date = ?, description = ? WHERE expense_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return false;
        }

        $description = $description ? (string) $description : null;

        // Change 'i' to 'd' for decimal type
        $stmt->bind_param('disss', $amount, $category_id, $date, $description, $expense_id);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error executing statement: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in editExpense: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Delete Expense
    public function deleteExpense($expense_id)
    {
        $query = "DELETE FROM expense WHERE expense_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param('i', $expense_id);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error executing statement: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in deleteExpense: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function getTotalExpenseToday($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
                  FROM expense 
                  WHERE user_id = ? AND DATE(date) = CURDATE()";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }

    // Get Total Expense This Week
    public function getTotalExpenseThisWeek($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
                  FROM expense 
                  WHERE user_id = ? 
                  AND YEARWEEK(date) = YEARWEEK(CURDATE())";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }

    // Get Total Expense This Month
    public function getTotalExpenseThisMonth($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
                  FROM expense 
                  WHERE user_id = ? 
                  AND YEAR(date) = YEAR(CURDATE()) 
                  AND MONTH(date) = MONTH(CURDATE())";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }
    // Get Total Expense This Year
    public function getTotalExpenseThisYear($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
              FROM expense 
              WHERE user_id = ? 
              AND YEAR(date) = YEAR(CURDATE())";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }

    // Get Total Expense Last 6 Months
    public function getTotalExpenseLast6Months($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
              FROM expense 
              WHERE user_id = ? 
              AND date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }

    public function getExpenseCategoriesSummary($user_id)
    {
        try {
            $query = "
                SELECT 
                    ec.name AS category_name, 
                    COALESCE(SUM(e.amount), 0) AS total_amount
                FROM 
                    expense_categories ec
                LEFT JOIN 
                    expenses e ON e.category_id = ec.category_id AND e.user_id = ?
                WHERE 
                    ec.user_id = ?
                GROUP BY 
                    ec.category_id, ec.name
                ORDER BY 
                    total_amount DESC
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Expense Categories Summary Error: " . $e->getMessage());
            return [];
        }
    }

    // Get Total Expense Yesterday
    public function getTotalExpenseYesterday($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
              FROM expense 
              WHERE user_id = ? 
              AND DATE(date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }

    // Get Total Expense Last Week
    public function getTotalExpenseLastWeek($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
              FROM expense 
              WHERE user_id = ? 
              AND DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) 
              AND DATE(date) < CURDATE()";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }

    // Get Total Expense Last Month
    public function getTotalExpenseLastMonth($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_expense 
              FROM expense 
              WHERE user_id = ? 
              AND DATE(date) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
              AND DATE(date) < CURDATE() 
              AND MONTH(date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
              AND YEAR(date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param('i', $user_id);

        if (!$stmt->execute()) {
            error_log("Error executing statement: " . $stmt->error);
            return 0;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_expense'] ?? 0;
    }
}
?>