<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Add Product</h1>
        <form method="POST" action="index.php?controller=Admin&action=store">
            <label>Name: <input type="text" name="name" required></label>
            <label>Stock Quantity: <input type="number" name="stock_quantity" min="0" required></label>
            <label>Price: <input type="number" name="price" step="0.01" min="0" required></label>
            <label>Category:
                <select name="cat_name" required>
                    <option value="Food">Food</option>
                    <option value="Drink">Drink</option>
                    <option value="Combo">Combo</option>
                </select>
            </label>
            <label>Image URL: <input type="text" name="image_url"></label>
            <label>Available: <input type="checkbox" name="is_available" checked></label>
            <label>Sale (%): <input type="number" name="sale" step="0.01" min="0" max="100" value="0"></label>
            <button class="btn" type="submit">Add</button>
            <a class="btn" href="index.php?controller=Admin&action=index">Back</a>
        </form>
    </div>
</body>
</html>
