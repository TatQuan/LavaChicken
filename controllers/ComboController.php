<?php
require_once 'config/database.php';
require_once 'models/Product.php';

class ComboController {
    private $conn;
    private $productModel;

    public function __construct() {
        $this->conn = new Database();
        $this->productModel = new Product($this->conn);
    }

    //index
    public function index() {

        $combos = $this->productModel->getProductsByCategory('combo');
        include './views/combo.php';
    }
    

}
?>