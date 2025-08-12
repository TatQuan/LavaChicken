<?php
require_once 'config/database.php';

class Product {

    private $conn;

    public function __construct() {
        $this->conn = new Database();
    }

    // Get all products
    public function getAllProducts() {
        $this->conn->query("SELECT * FROM product");
        return $this->conn->resultSet();
    }

    // Get all products except deleted
    public function getAllAvailableProducts() {
        $this->conn->query("SELECT * FROM product WHERE is_delete = FALSE");
        return $this->conn->resultSet();
    }

    // Get products by search keyword except deleted and unavailable
    public function searchProducts($keyword) {
        $this->conn->query("SELECT * FROM product WHERE name LIKE :keyword AND is_delete = FALSE AND is_available = 1");
        $this->conn->bind(':keyword', "%$keyword%");
        return $this->conn->resultSet();
    }

    // Get product by ID
    public function getProductById($id) {
        $this->conn->query("SELECT * FROM product WHERE product_id = :id");
        $this->conn->bind(':id', $id);
        return $this->conn->single();
    }

    // Get product by ID except deleted and unavailable
    public function getProductByIdExceptDeletedAndUnavailable($id) {
        $this->conn->query("SELECT * FROM product WHERE product_id = :id AND is_delete = FALSE AND is_available = 1");
        $this->conn->bind(':id', $id);
        return $this->conn->single();
    }

    // Get products by category
    public function getProductsByCategory($category) {
        $this->conn->query("SELECT * FROM product WHERE cat_name = :cat_name AND is_available = 1 AND is_delete = FALSE");
        $this->conn->bind(':cat_name', $category);
        return $this->conn->resultSet();
    }

    // Get available products
    public function getAvailableProducts() {
        $this->conn->query("SELECT * FROM product WHERE is_available = 1 AND is_delete = FALSE");
        return $this->conn->resultSet();
    }

    // Add new product
    public function addProduct($data) {
        $this->conn->query("
            INSERT INTO product (name, stock_quantity, price, cat_name, image_url, is_available, sale)
            VALUES (:name, :stock_quantity, :price, :cat_name, :image_url, :is_available, :sale)
        ");

        $this->conn->bind(':name', $data['name']);
        $this->conn->bind(':stock_quantity', $data['stock_quantity']);
        $this->conn->bind(':price', $data['price']);
        $this->conn->bind(':cat_name', $data['cat_name']);
        $this->conn->bind(':image_url', $data['image_url']);
        $this->conn->bind(':is_available', $data['is_available']);
        $this->conn->bind(':sale', $data['sale']);

        return $this->conn->execute();
    }

    // Update product
    public function updateProduct($id, $data) {
        $this->conn->query("
            UPDATE product 
            SET name = :name, stock_quantity = :stock_quantity, price = :price, 
                cat_name = :cat_name, image_url = :image_url, is_available = :is_available, sale = :sale
            WHERE product_id = :id
        ");

        $this->conn->bind(':id', $id);
        $this->conn->bind(':name', $data['name']);
        $this->conn->bind(':stock_quantity', $data['stock_quantity']);
        $this->conn->bind(':price', $data['price']);
        $this->conn->bind(':cat_name', $data['cat_name']);
        $this->conn->bind(':image_url', $data['image_url']);
        $this->conn->bind(':is_available', $data['is_available']);
        $this->conn->bind(':sale', $data['sale']);

        return $this->conn->execute();
    }

    // Delete product by setting availability to false
    public function deleteProduct($id) {
        $this->conn->query("UPDATE product SET is_delete = True WHERE product_id = :id");
        $this->conn->bind(':id', $id);
        return $this->conn->execute();
    }

    // Get products by array of ids
    public function getProductsByIds($ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $this->conn->query("SELECT * FROM product WHERE product_id IN ($placeholders) AND is_available = 1 AND is_delete = FALSE");
        foreach ($ids as $k => $id) {
            $this->conn->bind(($k+1), $id);
        }
        return $this->conn->resultSet();
    }
}
