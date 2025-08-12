<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Product List</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Product Management</h1>
        <a class="btn" href="index.php?controller=Admin&action=add">Add Product</a>
        <a class="btn" href="index.php?controller=Admin&action=dashboard">Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Stock</th><th>Price</th><th>Category</th>
                    <th>Image</th><th>Available</th><th>Sale</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['product_id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= $p['stock_quantity'] ?></td>
                    <td><?= $p['price'] ?></td>
                    <td><?= $p['cat_name'] ?></td>
                    <td>
                        <?php if ($p['image_url']): ?>
                            <img src="<?= htmlspecialchars($p['image_url']) ?>" width="50">
                        <?php endif; ?>
                    </td>
                    <td><?= $p['is_available'] ? 'Yes' : 'No' ?></td>
                    <td><?= $p['sale'] ?></td>
                    <td>
                        <a class="btn-edit" href="index.php?controller=Admin&action=edit&id=<?= $p['product_id'] ?>">Edit</a>
                        <a class="btn-delete" href="index.php?controller=Admin&action=delete&id=<?= $p['product_id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
