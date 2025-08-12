const items = document.querySelectorAll('.item');
const popup = document.getElementById('popup');
const closeBtn = document.getElementById('close');
const addToCartBtn = document.getElementById('popup-add-to-cart');

// Hàm load/save cart giống menu
function loadCart() {
    return JSON.parse(localStorage.getItem('lava_cart') || '[]');
}
function saveCart(c) {
    localStorage.setItem('lava_cart', JSON.stringify(c));
}

// Biến lưu tạm thông tin sản phẩm hiện tại trong popup
let currentProduct = null;

// Mở popup khi click vào combo
items.forEach(item => {
    item.addEventListener('click', () => {
        const title = item.dataset.title;
        const price = parseFloat(item.dataset.price.replace('$','').trim());
        const desc = item.dataset.desc;
        const img = item.dataset.img;

        document.getElementById('popup-title').textContent = title;
        document.getElementById('popup-price').textContent = "Giá: " + item.dataset.price;
        document.getElementById('popup-desc').textContent = desc;
        document.getElementById('popup-img').src = img;

        // Lưu thông tin sản phẩm hiện tại để add vào cart
        currentProduct = { name: title, price: price, image: img, qty: 1 };

        popup.style.display = 'block';
    });
});

// Đóng popup
closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
});
window.addEventListener('click', (e) => {
    if (e.target == popup) {
        popup.style.display = 'none';
    }
});

// Xử lý nút Add to Cart trong popup
addToCartBtn.addEventListener('click', () => {
    if (!currentProduct) return;
    const cart = loadCart();
    const found = cart.find(i => i.name === currentProduct.name);
    if (found) {
        found.qty++;
    } else {
        cart.push(currentProduct);
    }
    saveCart(cart);

    addToCartBtn.textContent = "✔ Added";
    setTimeout(() => addToCartBtn.textContent = "Add to Cart", 1000);
});
