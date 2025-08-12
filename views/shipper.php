<!-- filepath: e:\App\XAMPP\htdocs\LavaChicken\views\shipper.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Shipper Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/shipper.css">
</head>
<body>
<div class="shipper-container">
    <!-- Sidebar: Shipper Profile -->
    <aside class="shipper-sidebar">
        <div class="shipper-profile">
            <img src="https://img.icons8.com/?size=100&id=A8X7Kfs3pZns&format=png&color=FD7E14" alt="Shipper Avatar">
            <h2>
                <?php
                if (isset($_SESSION['user']['name'])) {
                    echo htmlspecialchars($_SESSION['user']['name']);
                } else {
                    echo "Shipper";
                }
                ?>
            </h2>
            <div style="color:#888;font-size:14px;">
                <?= isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : '' ?>
            </div>
        </div>
        <div>
            <div id="HistoryOrdersList" style="margin-top:10px;">
                <strong>History Orders</strong>
                <ul id="history-orders" style="font-size:13px; color:#444; padding-left:18px;">
                <?php if (!empty($history_orders)): ?>
                    <?php foreach ($history_orders as $order): ?>
                        <li>#<?= $order['order_id'] ?> - <?= htmlspecialchars($order['address']) ?> (<?= date('Y-m-d H:i', strtotime($order['order_time'])) ?>)</li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No history orders.</li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </aside>
    <!-- Main: Order Management -->
    <main class="shipper-main">
        <h1>Orders to Deliver</h1>
        <div class="shipper-orders-list">
            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Order Time</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody id="ordersTbody">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr data-order-id="<?= $order['order_id'] ?>">
                                <td><?= $order['order_id'] ?></td>
                                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                <td><?= htmlspecialchars($order['address']) ?></td>
                                <td><?= date('Y-m-d H:i', strtotime($order['order_time'])) ?></td>
                                <td class="status"><?= htmlspecialchars($order['status_order']) ?></td>
                                <td><button class="view-order-btn" onclick="viewOrderDetail(<?= $order['order_id'] ?>)">View</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No orders available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="orderDetail" class="order-detail-box" style="display:none;">
            <h2>Order Details</h2>
            <div id="orderDetailContent"></div>
            <div class="order-actions" id="orderActions"></div>
        </div>
    </main>
</div>
<script>
function viewOrderDetail(order_id) {
    fetch('index.php?controller=Shipper&action=viewOrder&order_id=' + order_id)
        .then(res => res.json())
        .then(data => {
            let order = data.order;
            let details = data.details;
            let content = `
                <div><b>Customer:</b> ${order.customer_name || ''}</div>
                <div><b>Address:</b> ${order.address}</div>
                <div><b>Order Time:</b> ${order.order_time}</div>
                <div><b>Status:</b> <span class="order-status">${order.status_order}</span></div>
                <div style="margin-top:10px;"><b>Products:</b>
                    <ul>
                        ${details.map(p => `<li>${p.product_name} x${p.quantity} (${Number(p.item_price).toLocaleString()}$)</li>`).join('')}
                    </ul>
                </div>
            `;
            document.getElementById('orderDetailContent').innerHTML = content;
            // Nút thao tác trạng thái
            let actions = '';
            actions += `<button onclick="updateOrderStatus(${order.order_id},'confirmed')">Confirm</button>`;
            actions += `<button onclick="updateOrderStatus(${order.order_id},'cancelled')">Cancel</button>`;
            actions += `<button onclick="updateOrderStatus(${order.order_id},'completed')">Complete</button>`;
            document.getElementById('orderActions').innerHTML = actions;
            document.getElementById('orderDetail').style.display = 'block';
        });
}

function updateOrderStatus(order_id, status) {
    fetch('index.php?controller=Shipper&action=updateStatus', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `order_id=${order_id}&status=${status}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Cập nhật lại bảng đơn hàng và chi tiết đơn hàng mà không reload trang
            refreshOrdersTable();
            // Nếu đang xem chi tiết đơn này thì cập nhật lại chi tiết
            viewOrderDetail(order_id);
            // Cập nhật lại history và stats
            fetchShipperStats();
            fetchCompletedOrders();
        }
    });
}

// Cập nhật lại bảng đơn hàng (AJAX)
function refreshOrdersTable() {
    fetch('index.php?controller=Shipper&action=index&ajax=1')
        .then(res => res.text())
        .then(html => {
            // Parse lại tbody từ HTML trả về
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, 'text/html');
            let newTbody = doc.querySelector('#ordersTbody');
            if (newTbody) {
                document.getElementById('ordersTbody').innerHTML = newTbody.innerHTML;
            }
        });
}

// Lấy số lượng đơn đã giao và đang giao cho shipper hiện tại
function fetchShipperStats() {
    fetch('index.php?controller=Shipper&action=getStats')
        .then(res => res.json())
        .then(data => {
            document.getElementById('deliveredCount').textContent = data.completed || 0;
            document.getElementById('inTransitCount').textContent = data.in_transit || 0;
        });
}
fetchShipperStats();

// Lấy danh sách đơn completed cho history
function fetchCompletedOrders() {
    fetch('index.php?controller=Shipper&action=getCompletedOrders')
        .then(res => res.json())
        .then(data => {
            let ul = document.getElementById('completedOrdersUl');
            ul.innerHTML = '';
            if (data.length === 0) {
                ul.innerHTML = '<li>No completed orders.</li>';
            } else {
                data.forEach(order => {
                    ul.innerHTML += `<li>#${order.order_id} - ${order.address} (${order.order_time})</li>`;
                });
            }
        });
}
fetchCompletedOrders();
</script>
</body>
</html>
