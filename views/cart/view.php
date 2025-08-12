<!DOCTYPE html>
<html>
<head>
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
</head>
<body>
<?php include 'views/header.php'; ?>
<div class="admin-container">
    <h1>Your Cart</h1>
    <?php if (empty($products)): ?>
        <p>No products in cart.</p>
    <?php else: ?>
        <form method="post" action="index.php?controller=Cart&action=update">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
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
                    <td>
                        <input type="number" name="quantities[<?= $p['product_id'] ?>]" value="<?= $qty ?>" min="1" style="width:50px;">
                    </td>
                    <td><?= number_format($subtotal,0,',','.') ?> VNĐ</td>
                    <td>
                        <a class="btn-delete" href="index.php?controller=Cart&action=remove&id=<?= $p['product_id'] ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div style="margin-top:16px;">
            <button class="btn" type="submit">Update Cart</button>
            <a class="btn" href="index.php?controller=Cart&action=checkout">Checkout</a>
        </div>
        </form>
        <div style="margin-top:16px;font-weight:bold;">Tổng cộng: <?= number_format($total,0,',','.') ?> VNĐ</div>
    <?php endif ?>
    
</div>
<?php include 'views/footer.html'; ?>
</body>
</html>
