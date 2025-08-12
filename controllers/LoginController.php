<?php
require_once './models/User.php';

class LoginController {

    public function index() {
        // Hiển thị form đăng nhập
        if (file_exists('./views/login.php')) {
            include './views/login.php';
        } else {
            echo "View file not found!";
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->login($username, $password);

            if ($user) {
                session_start();
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'role' => $user['role'],
                    'name' => $user['name'],
                    'username' => $user['username']
                    // thêm các thông tin khác nếu cần
                ];

                // Điều hướng theo role
                switch ($user['role']) {
                    case 'admin':
                        echo "<script>alert('Login successful as Admin!');</script>";
                        header("Location: index.php?controller=Admin&action=dashboard");
                        break;
                    case 'shipper':
                        echo "<script>alert('Login successful as Shipper!');</script>";
                        header("Location: index.php?controller=Shipper&action=index");
                        break;
                    default:
                        echo "<script>alert('Login successful!');</script>";
                        header("Location: index.php?controller=Home&action=index");
                        break;
                }
                exit;
            } else {
                // Đăng nhập thất bại: trả về lại form login với thông báo lỗi
                if (file_exists('views/login.php')) {
                    $login_error = "Invalid username or password!";
                    include 'views/login.php';
                } else {
                    echo "Login failed and view file not found!";
                }
                exit;
            }
        } else {
            // Hiển thị form login nếu GET
            include 'views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?controller=Login&action=login");
        exit;
    }
}
