<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu</title>
    <link rel="stylesheet" href="assets/css/menu.css" />
    <link rel="stylesheet" href="assets/js/menu.js" />

    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <div id="cart-notification" style="display:none;">Added to cart</div>
    <?php include 'header.php'; ?>
<main>
    <div class="menu-container">
        <h1>Menu</h1>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="menuSearchInput" placeholder="Search menu..." style="width: 300px; padding: 8px; border-radius: 6px; border: 1px solid #ccc; font-size: 1rem;">
        </div>

        <!-- Food Section -->
        <div class="menu-section">
            <h2>Food</h2>
            <div class="menu-items">
                <?php foreach ($foods as $food): ?>
                    <div class="menu-item" data-name="<?php echo strtolower($food['name']); ?>">
                        <img src="<?php echo !empty($food['image_url']) ? $food['image_url'] : 'assets/images/default-food.png'; ?>" alt="<?php echo $food['name']; ?>">
                        <div class="menu-item-info">
                            <h3><?php echo $food['name']; ?></h3>
                            <div class="price">$<?php echo $food['price']; ?></div>
                            <form class="add-to-cart-form" data-id="<?= $food['product_id'] ?>">
                                <input type="hidden" name="product_id" value="<?= $food['product_id'] ?>">
                                <input class="quantity-input" type="number" name="quantity" value="1" min="1">
                                <button class="order-btn" type="submit">Add to cart</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Drink Section -->
        <div class="menu-section">
            <h2>Drink</h2>
            <div class="menu-items">
                <?php foreach ($drinks as $drink): ?>
                    <div class="menu-item" data-name="<?php echo strtolower($drink['name']); ?>">
                        <img src="<?php echo $drink['image_url']; ?>" alt="<?php echo $drink['name']; ?>">
                        <div class="menu-item-info">
                            <h3><?php echo $drink['name']; ?></h3>
                            <div class="price">$<?php echo $drink['price']; ?></div>
                            <form class="add-to-cart-form" data-id="<?= $drink['product_id'] ?>">
                                <input type="hidden" name="product_id" value="<?= $drink['product_id'] ?>">
                                <input class="quantity-input" type="number" name="quantity" value="1" min="1">
                                <button class="order-btn" type="submit">Add to cart</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>
    <?php include 'footer.html'; ?>
    <script src="assets/js/menu.js"></script>
</body>
</html>