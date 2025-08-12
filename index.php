<?php
// This file is part of the LavaChicken project.
session_start();

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Nếu là admin và action=index thì chuyển vào dashboard
if ($controller === 'Admin' && $action === 'index') {
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
        header('Location: index.php?controller=Admin&action=dashboard');
        exit;
    }
}

switch ($controller) {
    case 'Login':
        require_once 'controllers/LoginController.php';
        $controllerObj = new LoginController();
        $controllerObj->$action();
        break;
    case 'Register':
        require_once 'controllers/RegisterController.php';
        $controllerObj = new RegisterController();
        $controllerObj->$action();
        break;
    case 'Home':
        require_once 'controllers/HomeController.php';
        $controllerObj = new HomeController();
        $controllerObj->$action();
        break;
    case 'Menu':
        require_once 'controllers/MenuController.php';
        $controllerObj = new MenuController();
        $controllerObj->$action();
        break;
    case 'Order':
        require_once 'controllers/OrderController.php';
        $controllerObj = new OrderController();
        $controllerObj->$action();
        break;
    case 'Admin':
        require_once 'controllers/AdminController.php';
        $controllerObj = new AdminController();
        $controllerObj->$action();
        break;
    case 'Shipper':
        require_once 'controllers/ShipperController.php';
        $controllerObj = new ShipperController();
        $controllerObj->$action();
        break;
    case 'Combo':
        require_once 'controllers/ComboController.php';
        $controllerObj = new ComboController();
        $controllerObj->$action();
        break;
    case 'Cart':
        require_once 'controllers/CartController.php';
        $controllerObj = new CartController();
        $controllerObj->$action();
        break;
    default:
        require_once './controllers/HomeController.php';
        $controllerObj = new HomeController();
        $controllerObj->$action();
        break;
}
?>