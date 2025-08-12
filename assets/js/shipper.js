const orders = [
  {
    id: 'OD001',
    name: 'Lê Thị Bích',
    phone: '+84912345678',
    address: 'Số 10, Đường Lý Thường Kiệt, Q.10, TP.HCM',
    products: [
      { title: 'Áo khoác gió', qty: 1, price: 450000 },
      { title: 'Mũ lưỡi trai', qty: 2, price: 150000 }
    ],
    status: 'pending',
    note: 'Gọi trước 30 phút'
  },
  {
    id: 'OD002',
    name: 'Trần Văn C',
    phone: '+84987654321',
    address: '291 Nguyễn Văn Cừ, P.1, Q.5, TP.HCM',
    products: [
      { title: 'Sách Tin học', qty: 1, price: 120000 }
    ],
    status: 'picking',
    note: ''
  }
];

const ordersListEl = document.getElementById('ordersList');
const recipientInfoEl = document.getElementById('recipientInfo');
const productListEl = document.getElementById('productList');
const orderValueEl = document.getElementById('orderValue');

function formatCurrency(v) {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(v);
}

function renderOrders() {
  ordersListEl.innerHTML = '';
  orders.forEach(order => {
    const div = document.createElement('div');
    div.className = 'order-item';
    div.textContent = `${order.id} - ${order.name}`;
    div.onclick = () => showOrderDetails(order);
    ordersListEl.appendChild(div);
  });
}

function showOrderDetails(order) {
  recipientInfoEl.innerHTML = `<strong>${order.name}</strong><br>${order.address}<br>${order.phone}`;
  productListEl.innerHTML = order.products.map(p =>
    `${p.title} (x${p.qty}) - ${formatCurrency(p.price)}`
  ).join('<br>');
  const total = order.products.reduce((sum, p) => sum + p.price * p.qty, 0);
  orderValueEl.textContent = `Tổng: ${formatCurrency(total)}`;
}

renderOrders();
