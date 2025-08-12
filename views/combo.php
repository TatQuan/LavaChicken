<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combo</title>
    <link rel="stylesheet" href="assets/css/combo.css" />
    <link rel="stylesheet" href="assets/js/combo.js" />
    <link rel="stylesheet" href="./config/database.php" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <?php include 'header.php'; ?>

    <div id="cart-notification" style="display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#222;color:#fff;padding:20px 40px;border-radius:8px;z-index:9999;font-size:1.2em;text-align:center;">
        Added to cart
    </div>

    <div class="combo-section">
        <h1>Combo</h1>
        <div class="combo-items">
            <?php if (!empty($combos) && is_array($combos)): ?>
                <?php foreach ($combos as $combo): ?>
                    <?php
                        $image = !empty($combo['image']) ? $combo['image'] : 'assets/images/default-food.png';
                    ?>
                    <div class="combo-item">
                        <img src="<?php echo $combo['image_url']; ?>" alt="<?php echo $combo['name']; ?>">
                        <div class="combo-item-info">
                            <h3><?php echo $combo['name']; ?></h3>
                            <div class="price">$<?php echo $combo['price']; ?></div>
                            <button 
                                class="order-btn"
                                data-id="<?php echo $combo['product_id']; ?>"
                                data-name="<?php echo htmlspecialchars($combo['name']); ?>"
                                data-price="<?php echo $combo['price']; ?>"
                                data-image="<?php echo !empty($combo['image_url']) ? $combo['image_url'] : 'assets/images/default-food.png'; ?>"
                                class="order-btn" onclick="addToCart(<?= $combo['product_id'] ?>)">Order</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No combos available.</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="footer"></div>
    <script src="assets/js/combo.js"></script>
</body>
</html>