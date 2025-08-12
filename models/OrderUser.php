<?php
require_once 'config/database.php';

class UserOrder {

    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }

    // create a new order
    public function createOrder($user_id, $total_price, $address, $status_order = 'pending') {
        $this->conn->query("
            INSERT INTO user_order (user_id, total_price, address, status_order) 
            VALUES (:user_id, :total_price, :address, :status_order)
        ");

        $this->conn->bind(':user_id', $user_id);
        $this->conn->bind(':total_price', $total_price);
        $this->conn->bind(':address', $address);
        $this->conn->bind(':status_order', $status_order);

        return $this->conn->execute();
    }

    // Get all orders of a user
    public function getOrdersByUser($user_id) {
        $this->conn->query("SELECT * FROM user_order WHERE user_id = :user_id ORDER BY order_time DESC");
        $this->conn->bind(':user_id', $user_id);
        return $this->conn->resultSet();
    }

    // Get an order by ID
    public function getOrderById($order_id) {
        $this->conn->query("SELECT * FROM user_order WHERE order_id = :order_id");
        $this->conn->bind(':order_id', $order_id);
        return $this->conn->single();
    }

    // Update order status
    public function updateOrderStatus($order_id, $status) {
        $this->conn->query("
            UPDATE user_order 
            SET status_order = :status 
            WHERE order_id = :order_id
        ");

        $this->conn->bind(':status', $status);
        $this->conn->bind(':order_id', $order_id);

        return $this->conn->execute();
    }

    // Delete an order (if needed)
    public function deleteOrder($order_id) {
        $this->conn->query("DELETE FROM user_order WHERE order_id = :order_id");
        $this->conn->bind(':order_id', $order_id);
        return $this->conn->execute();
    }

    // Get all orders (admin)
    public function getAllOrders() {
        $this->conn->query("SELECT * FROM user_order ORDER BY order_time DESC");
        return $this->conn->resultSet();
    }

    // Get all orders has name User
    public function getAllOrdersWithUserName() {
        $this->conn->query("
            SELECT 
                o.order_id,
                a.name AS customer_name,
                o.address,
                o.order_time,
                o.status_order,
                o.total_price
            FROM 
                user_order o
            LEFT JOIN 
                user_account a ON o.user_id = a.user_id;
        ");
        return $this->conn->resultSet();
    }

    // Count orders by status
    public function countOrdersByStatus($status) {
        $this->conn->query("SELECT COUNT(*) as total FROM user_order WHERE status_order = :status");
        $this->conn->bind(':status', $status);
        return $this->conn->single();
    }
}
