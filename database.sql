
-- Bảng sản phẩm
CREATE TABLE product (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    stock_quantity INT DEFAULT 0,
    price DECIMAL(10,2) NOT NULL,
    cat_name ENUM('Food', 'Drink', 'Combo') NOT NULL,
    image_url VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    sale DECIMAL(5,2) DEFAULT 0.00,
    is_delete BOOLEAN DEFAULT FALSE
);

-- Bảng người dùng
CREATE TABLE user_account (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20),
    role ENUM('customer', 'admin', 'shipper') DEFAULT 'customer',
    status_user ENUM('active', 'inactive') DEFAULT 'active',
	password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng đơn hàng
CREATE TABLE user_order (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NULL,
    address VARCHAR(255) NOT NULL,
    order_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    status_order ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    total_price DECIMAL(10,2),
    FOREIGN KEY (user_id) REFERENCES user_account(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Bảng chi tiết đơn hàng
CREATE TABLE order_details (
    detail_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NULL,
    product_id INT NULL,
    quantity INT DEFAULT 1,
    item_price DECIMAL(10,2), -- giá tại thời điểm đặt
    FOREIGN KEY (order_id) REFERENCES user_order(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Bảng giao hàng
CREATE TABLE delivery (
    delivery_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NULL,
    user_id INT,
    status_delivery ENUM('pending', 'in_transit', 'delivered', 'failed') DEFAULT 'pending',
    delivery_time DATETIME,
    FOREIGN KEY (order_id) REFERENCES user_order(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user_account(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
