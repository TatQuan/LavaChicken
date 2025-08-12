<?php
require_once 'models/User.php';

class RegisterController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    //index
    public function index() {
        include 'views/register.php';
    }

    // Handle user registration
    public function register() {
        $name = $_POST['name'] ?? '';
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->userModel->checkDuplicateEmail($email)) {
            $error_email = "Email is already taken";
            require_once 'views/register.php';
            return;
        }

        if ($this->userModel->checkDuplicateUsername($username)) {
            $error_username = "Username is already taken";
            require_once 'views/register.php';
            return;
        }

        $this->userModel->register($name, $username, $email, $phone, $password);
        $message = "Registration successful! You can now log in.";
        require_once 'views/login.php';
    }
}
