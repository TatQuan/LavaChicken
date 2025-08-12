<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="admin-container">
    <h1>Admin Dashboard</h1>
    <div style="margin-bottom: 24px;">
        <a class="btn" href="index.php?controller=Admin&action=users">User Management</a>
        <a class="btn" href="index.php?controller=Admin&action=index">Product Management</a>
    </div>
    <div class="dashboard-stats">
        <div class="stat-box">
            <div class="stat-title">Total Orders</div>
            <div class="stat-value"><?= $totalOrders ?></div>
        </div>
        <div class="stat-box">
            <div class="stat-title">Total Revenue</div>
            <div class="stat-value"><?= number_format($totalRevenue, 0, ',', '.') ?> VNĐ</div>
        </div>
    </div>
    <div style="margin-top:40px;">
        <h2 style="color: orange;">Monthly Revenue</h2>
        <canvas id="revenueChart" height="80"></canvas>
    </div>
</div>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            <?php
            $labels = [];
            $data = [];
            foreach (array_reverse($monthlyData) as $row) {
                $labels[] = '"' . $row['month'] . '"';
                $data[] = $row['revenue'] ?? 0;
            }
            echo implode(',', $labels);
            ?>
        ],
        datasets: [{
            label: 'Monthly Revenue ($)',
            data: [<?= implode(',', $data) ?>],
            backgroundColor: 'orange'
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>
