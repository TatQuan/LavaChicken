<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="admin-container">
    <h1>User Management</h1>
    <a class="btn" href="index.php?controller=Admin&action=dashboard">Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Username</th><th>Email</th><th>Phone</th>
                <th>Role</th><th>Status</th><th>Permissions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['user_id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['phone']) ?></td>
                <td><?= $u['role'] ?></td>
                <td><?= $u['status_user'] ?></td>
                <td>
                    <form method="POST" action="index.php?controller=Admin&action=updateUserRole" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= $u['user_id'] ?>">
                        <select name="role">
                            <option value="customer" <?= $u['role']=='customer'?'selected':'' ?>>customer</option>
                            <option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>admin</option>
                            <option value="shipper" <?= $u['role']=='shipper'?'selected':'' ?>>shipper</option>
                        </select>
                        <button class="btn-edit" type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
</body>
</html>
