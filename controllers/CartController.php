<?php
require_once 'models/Product.php';

class CartController {
    // Thêm sản phẩm vào cart với số lượng
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = max(1, intval($_POST['quantity'] ?? 1));
            if ($product_id) {
                if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
            }
        }
        header('Location: index.php?controller=Menu&action=index');
        exit;
    }

    // Xóa sản phẩm khỏi cart
    public function remove() {
        $product_id = $_GET['id'] ?? null;
        if ($product_id && isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        header('Location: index.php?controller=Cart&action=view');
        exit;
    }

    // Cập nhật số lượng sản phẩm trong cart
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $product_id => $qty) {
                $qty = max(1, intval($qty));
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] = $qty;
                }
            }
        }
        header('Location: index.php?controller=Cart&action=view');
        exit;
    }

    // Hiển thị giỏ hàng
    public function view() {
        $products = [];
        if (!empty($_SESSION['cart'])) {
            $productModel = new Product();
            $ids = array_keys($_SESSION['cart']);
            $products = $productModel->getProductsByIds($ids);
        }
        require 'views/cart/view.php';
    }

    // Trang xác nhận checkout (hiển thị form nhập địa chỉ và xác nhận)
    public function checkout() {
        $products = [];
        if (!empty($_SESSION['cart'])) {
            $productModel = new Product();
            $ids = array_keys($_SESSION['cart']);
            $products = $productModel->getProductsByIds($ids);
        }
        require 'views/cart/checkout.php';
    }

    // Lưu đơn hàng vào DB và chuyển cho shipper
    public function confirm() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=Login&action=index');
            exit;
        }
        if (empty($_SESSION['cart'])) {
            header('Location: index.php?controller=Cart&action=view');
            exit;
        }
        $address = trim($_POST['address'] ?? '');
        if ($address === '') {
            // Nếu thiếu địa chỉ, quay lại checkout và báo lỗi
            $_SESSION['checkout_address_error'] = 'Vui lòng nhập địa chỉ giao hàng!';
            header('Location: index.php?controller=Cart&action=checkout');
            exit;
        }
        require_once 'config/database.php';
        $db = new Database();
        $user_id = $_SESSION['user']['user_id'];
        $productModel = new Product();
        $ids = array_keys($_SESSION['cart']);
        $products = $productModel->getProductsByIds($ids);

        $total = 0;
        foreach ($products as $p) {
            $qty = $_SESSION['cart'][$p['product_id']];
            $total += $p['price'] * $qty;
        }

        // Lưu vào bảng user_order
        $db->query("INSERT INTO user_order (user_id, address, status_order, total_price) VALUES (:user_id, :address, 'pending', :total_price)");
        $db->bind(':user_id', $user_id);
        $db->bind(':address', $address);
        $db->bind(':total_price', $total);
        $db->execute();
        $order_id = $db->lastInsertId();

        // Lưu vào bảng order_details
        foreach ($products as $p) {
            $qty = $_SESSION['cart'][$p['product_id']];
            $db->query("INSERT INTO order_details (order_id, product_id, quantity, item_price) VALUES (:order_id, :product_id, :quantity, :item_price)");
            $db->bind(':order_id', $order_id);
            $db->bind(':product_id', $p['product_id']);
            $db->bind(':quantity', $qty);
            $db->bind(':item_price', $p['price']);
            $db->execute();
        }

        // Xóa cart
        unset($_SESSION['cart']);

        // Chuyển sang trang thông báo thành công
        require 'views/cart/success.php';
    }

    // AJAX thêm sản phẩm vào cart với số lượng
    public function ajaxAdd() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = max(1, intval($_POST['quantity'] ?? 1));
            if ($product_id) {
                if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
                echo json_encode(['success' => true]);
                return;
            }
        }
        echo json_encode(['success' => false]);
    }
}
