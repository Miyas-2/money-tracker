<?php
class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registerUser($username, $email, $password)
    {
        // Cek apakah username atau email sudah ada
        if ($this->userExists($username, $email)) {
            return false; // Pengguna sudah ada
        }

        $hashPass = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users(username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $username, $email, $hashPass);

        if ($stmt->execute()) {
            return true; // Registrasi berhasil
        } else {
            return false; // Registrasi gagal
        }
    }

    private function userExists($username, $email)
    {
        // Cek apakah username atau email sudah ada di database
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0; // Kembali true jika pengguna sudah ada
    }



    public function loginUser($email, $password)
    {
        // Update the SELECT statement to include profile_photo
        $stmt = $this->conn->prepare("SELECT user_id, username, email, password, profile_photo FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Explicitly set session with correct keys, including profile_photo
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'profile_photo' => $user['profile_photo'] // Add this line
                ];

                // Optional: Regenerate session ID for security
                session_regenerate_id(true);

                return $_SESSION['user'];
            }
        }
        return false;
    }

    public function getUserById($user_id)
    {
        // Update the SELECT statement to include profile_photo
        $stmt = $this->conn->prepare("SELECT user_id, username, email, profile_photo FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateUserProfile($user_id, $username, $email, $profile_photo = null)
    {
        // First, check if the username or email already exists for other users
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE (username = ? OR email = ?) AND user_id != ?");
        if (!$stmt) {
            throw new Exception("Database error: " . $this->conn->error);
        }

        $stmt->bind_param("ssi", $username, $email, $user_id);
        $stmt->execute();
        $stmt->store_result();

        // If a row is found, it means the username or email is already taken
        if ($stmt->num_rows > 0) {
            $stmt->close(); // Close the statement
            return false; // Indicate that the update cannot be performed
        }

        // Prepare the update statement
        $updateQuery = "UPDATE users SET username = ?, email = ?";
        if ($profile_photo) {
            $updateQuery .= ", profile_photo = ?";
        }
        $updateQuery .= " WHERE user_id = ?";

        $stmt = $this->conn->prepare($updateQuery);
        if (!$stmt) {
            throw new Exception("Database error: " . $this->conn->error);
        }

        if ($profile_photo) {
            $stmt->bind_param("sssi", $username, $email, $profile_photo, $user_id);
        } else {
            $stmt->bind_param("ssi", $username, $email, $user_id);
        }

        // Execute the statement
        $result = $stmt->execute();
        $stmt->close(); // Close the statement

        return $result; // Return the result of the execution
    }

    public function updateUserPassword($user_id, $current_password, $new_password)
    {
        // First, verify the current password
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($current_password, $user['password'])) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password
            $update_stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $update_stmt->bind_param("si", $new_hashed_password, $user_id);
            return $update_stmt->execute();
        }

        return false;
    }
}