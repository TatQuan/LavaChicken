<?php
require_once './models/Product.php';

class HomeController {

    public function index() {
        $productModel = new Product();
        $products = $productModel->getAllProducts();
        // Truyền biến $products sang view
        if (file_exists('./views/home.php')) {
            include './views/home.php';
        } else {
            echo "View file not found!";
        }
    }

    public function productDetails($id) {
        $productModel = new Product();
        $product = $productModel->getProductById($id);
        if (file_exists('./views/home/product_details.php')) {
            include './views/home/product_details.php';
        } else {
            echo "View file not found!";
        }
    }

    public function searchProducts($keyword) {
        $productModel = new Product();
        $products = $productModel->searchProducts($keyword);
        if (file_exists('./views/home/search_results.php')) {
            include './views/home/search_results.php';
        } else {
            echo "View file not found!";
        }
    }
}


