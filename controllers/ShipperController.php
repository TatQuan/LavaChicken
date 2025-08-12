<?php

require_once 'models/OrderUser.php';
require_once 'models/OrderDetail.php';
require_once 'config/database.php';

class ShipperController
{
    private $orderModel;
    private $orderDetailModel;

    public function __construct()
    {
        $this->orderModel = new UserOrder();
        $this->orderDetailModel = new OrderDetail();
    }

    // Hiển thị dashboard shipper
    public function index()
    {
        $db = new Database();
        // Lấy các đơn hàng cần giao (pending, confirmed, in_transit)
        $db->query("
            SELECT o.*, u.name AS customer_name
            FROM user_order o
            LEFT JOIN user_account u ON o.user_id = u.user_id
            WHERE o.status_order IN ('pending', 'confirmed', 'in_transit')
            ORDER BY o.order_time DESC
        ");
        $orders = $db->resultSet();

        // Lấy history_orders nếu cần cho sidebar
        $history_orders = [];
        if (!empty($_SESSION['user']['user_id'])) {
            $user_id = $_SESSION['user']['user_id'];
            $db->query("SELECT o.order_id, o.address, o.order_time 
                        FROM delivery d 
                        JOIN user_order o ON d.order_id = o.order_id 
                        WHERE d.user_id = :uid AND o.status_order IN ('completed', 'cancelled')
                        ORDER BY o.order_time DESC");
            $db->bind(':uid', $user_id);
            $history_orders = $db->resultSet();
        }

        // Nếu là AJAX thì chỉ trả về tbody
        if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
            ob_start();
            ?>
            <tbody id="ordersTbody">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr data-order-id="<?= $order['order_id'] ?>">
                            <td><?= $order['order_id'] ?></td>
                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td><?= htmlspecialchars($order['address']) ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($order['order_time'])) ?></td>
                            <td class="status"><?= htmlspecialchars($order['status_order']) ?></td>
                            <td><button class="view-order-btn" onclick="viewOrderDetail(<?= $order['order_id'] ?>)">View</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No orders available.</td></tr>
                <?php endif; ?>
            </tbody>
            <?php
            echo ob_get_clean();
            exit;
        }

        require 'views/shipper.php';
    }

    // Get the list of orders for the shipper
    public function getOrders($shipperId)
    {
        // TODO: Get the list of orders from the database by $shipperId
        // Return an array of orders (sample data)
        
    }

    // Xem chi tiết đơn hàng (AJAX)
    public function viewOrder()
    {
        $order_id = $_GET['order_id'] ?? 0;
        $db = new Database();
        $db->query("SELECT o.*, u.name AS customer_name FROM user_order o LEFT JOIN user_account u ON o.user_id = u.user_id WHERE o.order_id = :order_id");
        $db->bind(':order_id', $order_id);
        $order = $db->single();

        $orderDetailModel = new OrderDetail();
        $details = $orderDetailModel->getDetailsByOrderId($order_id);

        // Chuẩn bị dữ liệu trả về
        $result = [
            'order' => $order,
            'details' => $details
        ];
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

    // Update order status
    public function updateOrderStatus($orderId, $status)
    {
        // TODO: Update order status in the database
        // Return true if successful, false if failed
        return true;
    }

    // Lấy số lượng đơn đã giao và đang giao cho shipper hiện tại (AJAX)
    public function getStats() {
        session_start();
        $user_id = $_SESSION['user']['user_id'] ?? 0;
        require_once 'config/database.php';
        $db = new Database();
        // Đếm đơn đã giao
        $db->query("SELECT COUNT(*) AS cnt FROM delivery d 
            JOIN user_order o ON d.order_id = o.order_id 
            WHERE d.user_id = :uid AND o.status_order = 'completed'");
        $db->bind(':uid', $user_id);
        $completed = $db->single()['cnt'] ?? 0;

        // Đếm đơn đang giao
        $db->query("SELECT COUNT(*) AS cnt FROM delivery d 
            JOIN user_order o ON d.order_id = o.order_id 
            WHERE d.user_id = :uid AND o.status_order = 'in_transit'");
        $db->bind(':uid', $user_id);
        $in_transit = $db->single()['cnt'] ?? 0;

        header('Content-Type: application/json');
        echo json_encode([
            'completed' => $completed,
            'in_transit' => $in_transit
        ]);
        exit;
    }

    // Lấy danh sách đơn hàng đã giao cho shipper hiện tại (AJAX)
    public function getHistoryOrders() {
        session_start();
        $user_id = $_SESSION['user']['user_id'] ?? 0;
        require_once 'config/database.php';
        $db = new Database();
        $db->query("SELECT o.order_id, o.address, o.order_time 
                    FROM delivery d 
                    JOIN user_order o ON d.order_id = o.order_id 
                    WHERE d.user_id = :uid AND o.status_order IN ('completed', 'cancelled')
                    ORDER BY o.order_time DESC");
        $db->bind(':uid', $user_id);
        $orders = $db->resultSet();
        header('Content-Type: application/json');
        echo json_encode($orders);
        exit;
    }

    // Lấy danh sách đơn completed cho history (AJAX)
    public function getCompletedOrders() {
        session_start();
        $user_id = $_SESSION['user']['user_id'] ?? 0;
        require_once 'config/database.php';
        $db = new Database();
        $db->query("SELECT o.order_id, o.address, o.order_time 
                    FROM delivery d 
                    JOIN user_order o ON d.order_id = o.order_id 
                    WHERE d.user_id = :uid AND o.status_order = 'completed'
                    ORDER BY o.order_time DESC");
        $db->bind(':uid', $user_id);
        $orders = $db->resultSet();
        header('Content-Type: application/json');
        echo json_encode($orders);
        exit;
    }

    // Cập nhật trạng thái đơn hàng (AJAX)
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $order_id = $_POST['order_id'] ?? 0;
            $status = $_POST['status'] ?? '';
            $user_id = $_SESSION['user']['user_id'] ?? 0;
            require_once 'config/database.php';
            $db = new Database();
            // Chỉ cho phép các trạng thái này
            $allowed = ['confirmed', 'cancelled', 'completed'];
            if (!in_array($status, $allowed)) {
                echo json_encode(['success' => false]);
                exit;
            }
            // Cập nhật trạng thái đơn hàng
            $db->query("UPDATE user_order SET status_order = :status WHERE order_id = :order_id");
            $db->bind(':status', $status);
            $db->bind(':order_id', $order_id);
            $success = $db->execute();

            // Nếu có bảng delivery, xử lý khi confirmed
            if ($success) {
                if ($status === 'confirmed') {
                    // Kiểm tra đã có delivery chưa
                    $db->query("SELECT delivery_id FROM delivery WHERE order_id = :order_id");
                    $db->bind(':order_id', $order_id);
                    $delivery = $db->single();
                    if ($delivery) {
                        // Nếu đã có thì cập nhật lại user_id và status_delivery
                        $db->query("UPDATE delivery SET user_id = :user_id, status_delivery = 'pending', delivery_time = NOW() WHERE order_id = :order_id");
                        $db->bind(':user_id', $user_id);
                        $db->bind(':order_id', $order_id);
                        $db->execute();
                    } else {
                        // Nếu chưa có thì thêm mới
                        $db->query("INSERT INTO delivery (order_id, user_id, status_delivery, delivery_time) VALUES (:order_id, :user_id, 'pending', NOW())");
                        $db->bind(':order_id', $order_id);
                        $db->bind(':user_id', $user_id);
                        $db->execute();
                    }
                }
                // Các trạng thái khác vẫn cập nhật như cũ
                $delivery_status = null;
                if ($status === 'cancelled') $delivery_status = 'failed';
                if ($status === 'completed') $delivery_status = 'delivered';
                if ($delivery_status) {
                    $db->query("UPDATE delivery SET status_delivery = :dstatus, delivery_time = NOW() WHERE order_id = :order_id");
                    $db->bind(':dstatus', $delivery_status);
                    $db->bind(':order_id', $order_id);
                    $db->execute();
                }
            }

            echo json_encode(['success' => $success]);
            exit;
        }
    }
}
