<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <link rel="stylesheet" href="./assets/css/home.css" />
    <link rel="stylesheet" href="./assets/css/footer.css" />
    <link rel="stylesheet" href="./assets/css/header.css" />
    <script src="./assets/js/home.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="slider-container">
            <div class="main-slide-wrapper">
                <img class="main-slide" src="https://tse1.mm.bing.net/th/id/OIP.qaOJCXub2RFXZ4wTgW6whAHaE8?cb=thfvnext&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Main slide" />
            </div>
            <img class="side-slide left" src="https://cdn.apartmenttherapy.info/image/upload/f_auto,q_auto:eco,c_fill,g_auto,w_1500,ar_3:2/k/Photo/Recipe%20Ramp%20Up/2022-05-Fried-Chicken-Sandwich/chicken-sandwich-4" alt="Left Slide" />
            <img class="side-slide right" src="https://tse1.mm.bing.net/th/id/OIP.qaOJCXub2RFXZ4wTgW6whAHaE8?cb=thfvnext&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Right Slide" />
        </div>

        <button class="slider-arrow left">&#10094;</button>
        <button class="slider-arrow right">&#10095;</button>

        <div class="delivery-section">
            <div class="delivery-tabs">
            <button class="tab active" id="localBtn">Local Delivery</button>
            <button class="tab" id="pickupBtn">Order To Pick Up</button>
            </div>

            <div class="delivery-search">
            <input type="text" placeholder="Please enter shipping address" />
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
            </div>
        </div>

        <div class="menu-tabs">
            <span class="tab-text active" id="mustTryTab">Delicious dish must try</span>
            <span class="tab-text" id="promoTab">Promotion</span>
        </div>

        <div class="dish-grid" id="dishGrid">
            <img src="https://tse2.mm.bing.net/th/id/OIP._ldJicFY9qwfL3ZGIqLDUQHaLG?cb=thfvnext&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Dish 1" />
            <img src="https://cookingcircuit.com/wp-content/uploads/2025/08/Restaurant-Style-Chicken-Fried-Rice.webp" alt="Dish 2" />
            <img src="https://th.bing.com/th/id/R.9c15fc51f59aefe032973e9f376730d0?rik=%2bA2%2bX2VA8pb6cw&pid=ImgRaw&r=0" alt="Dish 3" />
            <img src="https://www.thecountrycook.net/wp-content/uploads/2022/02/thumbnail-Chicken-Fried-Chicken-1024x1025.jpg" alt="Dish 4" />
        </div>
    </main>

    <?php include 'footer.html'; ?>
</body>
</html>