<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" href="cart.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&display=swap">
</head>
<body>
  <div id="header"></div>

  <main>
    <main class="container">
      <h1 class="page-title">Your Cart <span class="muted count">(0 item)</span></h1>

  <!-- empty cart -->
    <div id="cart-empty" class="empty hidden">
      <img src="images/empty-cart.png" alt="Cart empty" class="empty-img">
      <p>You have not added any products to your cart yet.
      Take a look and choose the product your pet needs, there are many good products here ;)</p>
      <a class="btn" href="menu.html">Go to Menu</a>
    </div>

  <!-- add products -->
    <section id="cart-section" class="cart hidden" aria-live="polite">
      <div class="cart-header row">
        <div class="col item">Item</div>
        <div class="col price">Price</div>
        <div class="col qty">Quantity</div>
        <div class="col total">Total</div>
      </div>
      <div id="cart-items" class="cart-items"></div>

      <div class="cart-summary">
        <div class="totals">
          <div class="grand">
            <span>Grand Total:</span>
            <span id="grand">$0.00</span>
          </div>
          <div class="actions">
            <button id="continue-shopping" class="btn ghost">Back to Menu</button>
            <a href="pay.html"><button class="btn primary">Checkout</button></a>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  <div id="footer"></div>
  <script src="cart.js" defer></script>
  <script src="header-footer.js"></script>
    <script>
      loadHTML("header", "header.html");
      loadHTML("footer", "footer.html");
</script>
</body>
</html>