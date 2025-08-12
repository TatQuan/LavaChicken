<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="assets/css/footer.css" />
    <link rel="stylesheet" href="assets/css/order.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="track-container">
            <img src="https://img.icons8.com/?size=100&id=9207&format=png&color=FD7E14" alt="Chicken" class="chicken-icon">
            <div class="search-box">
                <label for="address">Track your order:</label>
                <div class="search-bar">
                    <input type="text" id="address" placeholder="Please enter shipping address">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

    <!-- Popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span id="close-popup" class="close">&times;</span>
            <h2>Order Tracking</h2>
            <p id="popup-text"></p>
        </div>
    </div>
    </main>

    <div id="footer"></div>
    <script src="order.js"></script>
    <?php include 'footer.html'; ?>
</script>
</body>
</html>