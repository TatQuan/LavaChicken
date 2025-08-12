<?php
require_once 'models/Product.php';

class AdminController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    // Dashboard
    public function dashboard() {
        require_once 'config/database.php';
        $db = new Database();

        // Sum of order
        $db->query("SELECT COUNT(*) as total_orders FROM user_order");
        $totalOrders = $db->single()['total_orders'];

        // Sum of revenue
        $db->query("SELECT SUM(total_price) as total_revenue FROM user_order WHERE status_order = 'completed'");
        $totalRevenue = $db->single()['total_revenue'] ?? 0;

        // Monthly revenue data (last 12 months)
        $db->query("
            SELECT DATE_FORMAT(order_time, '%Y-%m') as month, SUM(total_price) as revenue
            FROM user_order
            WHERE status_order = 'completed'
            GROUP BY month
            ORDER BY month DESC
            LIMIT 12
        ");
        $monthlyData = $db->resultSet();

        require 'views/admin/dashboard.php';
    }

    // List all products
    public function index() {
        $products = $this->productModel->getAllAvailableProducts();
        require 'views/admin/product_list.php';
    }

    // Show add product form
    public function add() {
        require 'views/admin/product_add.php';
    }

    // Handle add product
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'stock_quantity' => $_POST['stock_quantity'],
                'price' => $_POST['price'],
                'cat_name' => $_POST['cat_name'],
                'image_url' => $_POST['image_url'],
                'is_available' => isset($_POST['is_available']) ? 1 : 0,
                'sale' => $_POST['sale']
            ];
            $this->productModel->addProduct($data);
            header('Location: index.php?controller=Admin&action=index');
            exit;
        }
    }

    // Show edit product form
    public function edit() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $product = $this->productModel->getProductById($id);
            require 'views/admin/product_edit.php';
        }
    }

    // Handle update product
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['product_id'];
            $data = [
                'name' => $_POST['name'],
                'stock_quantity' => $_POST['stock_quantity'],
                'price' => $_POST['price'],
                'cat_name' => $_POST['cat_name'],
                'image_url' => $_POST['image_url'],
                'is_available' => isset($_POST['is_available']) ? 1 : 0,
                'sale' => $_POST['sale']
            ];
            $this->productModel->updateProduct($id, $data);
            header('Location: index.php?controller=Admin&action=index');
            exit;
        }
    }

    // Handle delete product
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->productModel->deleteProduct($id);
        }
        header('Location: index.php?controller=Admin&action=index');
        exit;
    }

    // Manage users
    public function users() {
        require_once 'config/database.php';
        $db = new Database();
        $db->query("SELECT * FROM user_account");
        $users = $db->resultSet();
        require 'views/admin/user_list.php';
    }

    // Update user role
    public function updateUserRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'config/database.php';
            $db = new Database();
            $user_id = $_POST['user_id'];
            $role = $_POST['role'];
            $db->query("UPDATE user_account SET role = :role WHERE user_id = :user_id");
            $db->bind(':role', $role);
            $db->bind(':user_id', $user_id);
            $db->execute();
        }
        header('Location: index.php?controller=Admin&action=users');
        exit;
    }
}
