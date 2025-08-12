<!DOCTYPE html>
<html>
<head>
    <title>Confirm Order</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-container">
    <h1>Confirm Order</h1>
    <?php
    $address = '';
    $addressError = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $address = trim($_POST['address'] ?? '');
        if ($address === '') {
            $addressError = 'Please enter a shipping address!';
        }
    }
    ?>
    <?php if (empty($products)): ?>
        <p>No products to checkout.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; foreach ($products as $p): 
                    $qty = $_SESSION['cart'][$p['product_id']];
                    $subtotal = $p['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= number_format($p['price'],0,',','.') ?> VNĐ</td>
                    <td><?= $qty ?></td>
                    <td><?= number_format($subtotal,0,',','.') ?> VNĐ</td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div style="margin-top:16px;font-weight:bold;">Total: <?= number_format($total,0,',','.') ?> VNĐ</div>
        <form method="post" action="index.php?controller=Cart&action=checkout">
            <div style="margin:16px 0;">
                <label for="address">Shipping Address:</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($address ?: ($_SESSION['user']['address'] ?? '')) ?>" style="width:60%;" required>
                <?php if ($addressError): ?>
                    <div style="color:red;"><?= $addressError ?></div>
                <?php endif; ?>
            </div>
            <button class="btn" type="submit">Confirm Order</button>
            <a class="btn" href="index.php?controller=Cart&action=view">Back to Cart</a>
        </form>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$addressError): ?>
            <form id="real-checkout" method="post" action="index.php?controller=Cart&action=confirm" style="display:none;">
                <input type="hidden" name="address" value="<?= htmlspecialchars($address) ?>">
            </form>
            <script>
                document.getElementById('real-checkout').submit();
            </script>
        <?php endif; ?>
    <?php endif ?>
</div>
</body>
</html>
