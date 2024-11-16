<?php
class Income
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create (Add) Income
    public function addIncome($user_id, $amount, $category_id, $date, $description)
    {
        // Additional input validation
        if (!is_numeric($amount) || $amount <= 0) {
            error_log("Invalid income amount: $amount");
            return false;
        }

        $query = "INSERT INTO income (user_id, amount, category_id, date, description) VALUES (?, ?, ?, ?, ?)";

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
            error_log("Exception in addIncome: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Read (Get) Incomes by User
    public function getIncomesByUser($user_id)
    {
        $query = "SELECT income.*, categories.name AS category_name
                  FROM income
                  JOIN categories ON income.category_id = categories.category_id
                  WHERE income.user_id = ?
                  ORDER BY income.date DESC"; // Mengurutkan berdasarkan tanggal secara ascending

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

    // Edit Income
    public function editIncome($income_id, $amount, $category_id, $date, $description)
    {
        if (!is_numeric($amount) || $amount <= 0) {
            error_log("Invalid income amount: $amount");
            return false;
        }

        // Format the amount to two decimal places
        $amount = number_format((float) $amount, 2, '.', '');

        $query = "UPDATE income SET amount = ?, category_id = ?, date = ?, description = ? WHERE income_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return false;
        }

        $description = $description ? (string) $description : null;

        // Change 'i' to 'd' for decimal type
        $stmt->bind_param('disss', $amount, $category_id, $date, $description, $income_id);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error executing statement: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in editIncome: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Delete Income
    public function deleteIncome($income_id)
    {
        $query = "DELETE FROM income WHERE income_id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("Error preparing statement: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param('i', $income_id);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error executing statement: " . $stmt->error);
                return false;
            }
        } catch (Exception $e) {
            error_log("Exception in deleteIncome: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Get Total Income Today
    public function getTotalIncomeToday($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
                   FROM income 
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
        return $row['total_income'] ?? 0;
    }

    // Get Total Income This Week
    public function getTotalIncomeThisWeek($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
                   FROM income 
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
        return $row['total_income'] ?? 0;
    }

    // Get Total Income This Month
    public function getTotalIncomeThisMonth($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
                   FROM income 
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
        return $row['total_income'] ?? 0;
    }

    // Get Total Income This Year
    public function getTotalIncomeThisYear($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
              FROM income 
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
        return $row['total_income'] ?? 0;
    }

    // Get Total Income Last 6 Months
    public function getTotalIncomeLast6Months($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
              FROM income 
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
        return $row['total_income'] ?? 0;
    }
    // Get Total Income Yesterday
    public function getTotalIncomeYesterday($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
              FROM income 
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
        return $row['total_income'] ?? 0;
    }
    // Get Total Income Last Week
    public function getTotalIncomeLastWeek($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
              FROM income 
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
        return $row['total_income'] ?? 0;
    }

    // Get Total Income Last Month
    public function getTotalIncomeLastMonth($user_id)
    {
        $query = "SELECT COALESCE(SUM(amount), 0) AS total_income 
              FROM income 
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
        return $row['total_income'] ?? 0;
    }

}
?>