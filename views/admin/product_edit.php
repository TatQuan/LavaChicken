<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit Product</h1>
        <form method="POST" action="index.php?controller=Admin&action=update">
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
            <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required></label>
            <label>Stock Quantity: <input type="number" name="stock_quantity" min="0" value="<?= $product['stock_quantity'] ?>" required></label>
            <label>Price: <input type="number" name="price" step="0.01" min="0" value="<?= $product['price'] ?>" required></label>
            <label>Category:
                <select name="cat_name" required>
                    <option value="Food" <?= $product['cat_name']=='Food'?'selected':'' ?>>Food</option>
                    <option value="Drink" <?= $product['cat_name']=='Drink'?'selected':'' ?>>Drink</option>
                    <option value="Combo" <?= $product['cat_name']=='Combo'?'selected':'' ?>>Combo</option>
                </select>
            </label>
            <label>Image URL: <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>"></label>
            <label>Available: <input type="checkbox" name="is_available" <?= $product['is_available'] ? 'checked' : '' ?>></label>
            <label>Sale (%): <input type="number" name="sale" step="0.01" min="0" max="100" value="<?= $product['sale'] ?>"></label>
            <button class="btn" type="submit">Update</button>
            <a class="btn" href="index.php?controller=Admin&action=index">Back</a>
        </form>
    </div>
</body>
</html>
