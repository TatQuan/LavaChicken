<?php

require_once 'config/database.php';

class Delivery {

    private $con;

    public function __construct() {
        $this->con = new Database();
    }

    // Create a new delivery
    public function createDelivery($order_id, $user_id) {
        $this->con->query("
            INSERT INTO delivery (order_id, user_id) 
            VALUES (:order_id, :user_id)
        ");

        $this->con->bind(':order_id', $order_id);
        $this->con->bind(':user_id', $user_id);

        return $this->con->execute();
    }

    // Update delivery status
    public function updateDeliveryStatus($delivery_id, $status, $delivery_time = null) {
        $this->con->query("
            UPDATE delivery 
            SET status_delivery = :status, delivery_time = :delivery_time 
            WHERE delivery_id = :delivery_id
        ");

        $this->con->bind(':status', $status);
        $this->con->bind(':delivery_time', $delivery_time ?? date('Y-m-d H:i:s'));
        $this->con->bind(':delivery_id', $delivery_id);

        return $this->con->execute();
    }

    // Get delivery information by order
    public function getDeliveryByOrderId($order_id) {
        $this->con->query("SELECT * FROM delivery WHERE order_id = :order_id");
        $this->con->bind(':order_id', $order_id);
        return $this->con->single();
    }

    // Get a list of deliveries by shipper
    public function getDeliveriesByShipper($user_id) {
        $this->con->query("
            SELECT d.*, o.total_price, o.status_order 
            FROM delivery d
            JOIN user_order o ON d.order_id = o.order_id
            WHERE d.user_id = :user_id
            ORDER BY d.delivery_time DESC
        ");
        $this->con->bind(':user_id', $user_id);
        return $this->con->resultSet();
    }

    // Delete a delivery (if needed)
    public function deleteDelivery($delivery_id) {
        $this->con->query("DELETE FROM delivery WHERE delivery_id = :delivery_id");
        $this->con->bind(':delivery_id', $delivery_id);
        return $this->con->execute();
    }
}
