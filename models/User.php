<?php
require_once 'config/database.php';

class User {

    private $conn;

    public function __construct() {
        // Create Database instance
        $this->conn = new Database();
    }

    // Register new user
    public function register($name, $username, $email, $phone, $password) {
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement for user registration
        $this->conn->query("INSERT INTO user_account (name, username, email, phone, password_hash) 
                            VALUES (:name, :username, :email, :phone, :password_hash)");

        // Bind values to the SQL statement
        $this->conn->bind(':name', $name);
        $this->conn->bind(':username', $username);
        $this->conn->bind(':email', $email);
        $this->conn->bind(':phone', $phone);
        $this->conn->bind(':password_hash', $passwordHash);

        // Execute the statement and return the result
        return $this->conn->execute();
    }

    // User login
    public function login($username, $password) {
        // Get user information by username
        $this->conn->query("SELECT * FROM user_account WHERE username = :username LIMIT 1");
        $this->conn->bind(':username', $username);

        $user = $this->conn->single(); // Get user information

        // Check password
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user; // Login successful, return user information
        } else {
            return false; // Login failed
        }
    }

    // Get user information by ID
    public function getUserById($id) {
        $this->conn->query("SELECT * FROM user_account WHERE user_id = :id");
        $this->conn->bind(':id', $id);
        return $this->conn->single(); // Get user information
    }

    // Update user information
    public function updateUser($id, $name, $username, $email, $phone, $role, $status_user) {
        $this->conn->query("UPDATE user_account 
                            SET name = :name, username = :username, email = :email, phone = :phone, 
                                role = :role, status_user = :status_user 
                            WHERE user_id = :id");

        // Bind values to the SQL statement
        $this->conn->bind(':id', $id);
        $this->conn->bind(':name', $name);
        $this->conn->bind(':username', $username);
        $this->conn->bind(':email', $email);
        $this->conn->bind(':phone', $phone);
        $this->conn->bind(':role', $role);
        $this->conn->bind(':status_user', $status_user);

        // Execute the statement and return the result
        return $this->conn->execute();
    }

    // Delete user
    public function deleteUser($id) {
        $this->conn->query("DELETE FROM user_account WHERE user_id = :id");
        $this->conn->bind(':id', $id);
        return $this->conn->execute();
    }

    // Check for duplicate email
    public function checkDuplicateEmail($email) {
        $this->conn->query("SELECT * FROM user_account WHERE email = :email LIMIT 1");
        $this->conn->bind(':email', $email);
        return $this->conn->single();
    }

    // Check for duplicate username
    public function checkDuplicateUsername($username) {
        $this->conn->query("SELECT * FROM user_account WHERE username = :username LIMIT 1");
        $this->conn->bind(':username', $username);
        return $this->conn->single();
    }

}
