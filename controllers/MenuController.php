<?php
require_once 'config/database.php';
require_once 'models/Product.php';

class MenuController {
    private $conn;
    private $productModel;

    public function __construct() {
        $this->conn = new Database();
        $this->productModel = new Product($this->conn);
    }

    //index
    public function index() {
        $foods = $this->productModel->getProductsByCategory('Food');
        $drinks = $this->productModel->getProductsByCategory('Drink');
        include './views/menu.php';
    }

    // Search products
    public function search($keyword) {
        $results = $this->productModel->searchProducts($keyword);
        include './views/search_results.php';
    }


}
?>

