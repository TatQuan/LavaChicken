<?php
require_once 'config/database.php';

class OrderDetail {

    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }

    // Add a product to the order
    public function addOrderDetail($order_id, $product_id, $quantity, $item_price) {
        $this->conn->query("
            INSERT INTO order_details (order_id, product_id, quantity, item_price)
            VALUES (:order_id, :product_id, :quantity, :item_price)
        ");

        $this->conn->bind(':order_id', $order_id);
        $this->conn->bind(':product_id', $product_id);
        $this->conn->bind(':quantity', $quantity);
        $this->conn->bind(':item_price', $item_price);

        return $this->conn->execute();
    }

    // Get order details by order_id
    public function getDetailsByOrderId($order_id) {
        $this->conn->query("
            SELECT od.*, p.name AS product_name, p.image_url
            FROM order_details od
            JOIN product p ON od.product_id = p.product_id
            WHERE od.order_id = :order_id
        ");
        $this->conn->bind(':order_id', $order_id);
        return $this->conn->resultSet();
    }

    // Get total items in order
    public function getTotalItemsInOrder($order_id) {
        $this->conn->query("
            SELECT SUM(quantity) AS total_items 
            FROM order_details 
            WHERE order_id = :order_id
        ");
        $this->conn->bind(':order_id', $order_id);
        return $this->conn->single();
    }

    // Delete order detail (if needed)
    public function deleteDetail($detail_id) {
        $this->conn->query("DELETE FROM order_details WHERE detail_id = :detail_id");
        $this->conn->bind(':detail_id', $detail_id);
        return $this->conn->execute();
    }

    // Delete all details by order (if order is deleted)
    public function deleteDetailsByOrderId($order_id) {
        $this->conn->query("DELETE FROM order_details WHERE order_id = :order_id");
        $this->conn->bind(':order_id', $order_id);
        return $this->conn->execute();
    }
}
