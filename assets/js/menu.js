const tabs = document.querySelectorAll('.tab');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
  });
});

(function(){
  function loadCart(){return JSON.parse(localStorage.getItem('lava_cart')||'[]');}
  function saveCart(c){localStorage.setItem('lava_cart',JSON.stringify(c));}

  document.addEventListener("DOMContentLoaded",()=>{
    document.querySelectorAll(".order-btn[data-id]").forEach(btn => {
      btn.addEventListener("click", function() {
        const name = btn.getAttribute("data-name");
        const price = parseFloat(btn.getAttribute("data-price"));
        const img = btn.getAttribute("data-image");
        if(!name || !price) return;
        const cart = loadCart();
        const found = cart.find(i=>i.name===name);
        if(found) found.qty++;
        else cart.push({name,price,image:img,qty:1});
        saveCart(cart);

        // Show notification
        let notification = document.getElementById("cart-notification");
        if(notification){
          notification.style.display = "block";
          notification.style.animation = "fadeInOut 2s forwards";
          setTimeout(()=> {
            notification.style.display = "none";
            notification.style.animation = "";
          }, 2000);
        }
      });
    });

    // Add fadeInOut animation to the page if not already present
    if (!document.getElementById("fadeInOut-style")) {
      const style = document.createElement('style');
      style.id = "fadeInOut-style";
      style.innerHTML = `
        @keyframes fadeInOut {
          0% { opacity: 0; }
          10% { opacity: 1; }
          90% { opacity: 1; }
          100% { opacity: 0; }
        }
      `;
      document.head.appendChild(style);
    }
  });
})();

// // Menu search functionality
// document.addEventListener("DOMContentLoaded", function() {
//     const searchInput = document.getElementById('menuSearchInput');
//     if (searchInput) {
//         searchInput.addEventListener('input', function() {
//             const query = this.value.trim().toLowerCase();
//             document.querySelectorAll('.menu-item').forEach(function(item) {
//                 const name = item.getAttribute('data-name');
//                 if (query && name && name.includes(query)) {
//                     item.style.display = '';
//                 } else if (!query) {
//                     item.style.display = '';
//                 } else {
//                     item.style.display = 'none';
//                 }
//             });
//         });
//     }
// });

// AJAX add to cart
    document.querySelectorAll('.add-to-cart-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch('index.php?controller=Cart&action=ajaxAdd', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const notify = document.getElementById('cart-notification');
                    notify.style.display = 'block';
                    notify.textContent = 'Added to cart';
                    setTimeout(() => { notify.style.display = 'none'; }, 1200);
                }
            });
        });
    });
//           notification.style.display = "block";
//           notification.style.animation = "fadeInOut 2s forwards";

//           // Ẩn sau 2s
//           setTimeout(() => {
//               notification.style.display = "none";
//           }, 2000);
//       });
//   }

// // Add fadeInOut animation to the page
// document.addEventListener("DOMContentLoaded",()=>{
//   const style = document.createElement('style');
//   style.innerHTML = `
//     @keyframes fadeInOut {
//       0% { opacity: 0; }
//       10% { opacity: 1; }
//       90% { opacity: 1; }
//       100% { opacity: 0; }
//     }
//   ;
//   document.head.appendChild(style);
// });
    // Menu search functionality
    document.getElementById('menuSearchInput').addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        document.querySelectorAll('.menu-item').forEach(function(item) {
            const name = item.getAttribute('data-name');
            if (!query || name.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
// AJAX add to cart
    document.querySelectorAll('.add-to-cart-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch('index.php?controller=Cart&action=ajaxAdd', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const notify = document.getElementById('cart-notification');
                    notify.style.display = 'block';
                    notify.textContent = 'Added to cart';
                    setTimeout(() => { notify.style.display = 'none'; }, 1200);
                }
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("menuSearchInput");
    const menuList = document.getElementById("menuList");
    const noResult = document.getElementById("noResult");

    function loadMenu(query = '') {
        fetch("search_menu.php?q=" + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                menuList.innerHTML = "";
                if (data.length > 0) {
                    noResult.style.display = "none";
                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.className = "menu-item";
                        div.textContent = `${item.name} - ${item.price} VNĐ`;
                        menuList.appendChild(div);
                    });
                } else {
                    noResult.style.display = "block";
                }
            })
            .catch(err => console.error(err));
    }

    // Load tất cả món ban đầu
    loadMenu();

    // Tìm kiếm khi gõ
    searchInput.addEventListener("input", function () {
        const query = this.value.trim();
        loadMenu(query);
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("menuSearchInput");
    const menuList = document.getElementById("menuList");
    const noResult = document.getElementById("noResult");

    function loadMenu(query = '') {
        fetch("search_menu.php?q=" + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                menuList.innerHTML = "";
                if (data.length > 0) {
                    noResult.style.display = "none";
                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.className = "menu-item";
                        div.textContent = `${item.name} - ${item.price} VNĐ`;
                        menuList.appendChild(div);
                    });
                } else {
                    noResult.style.display = "block";
                }
            })
            .catch(err => console.error(err));
    }

    // Load tất cả món ban đầu
    loadMenu();

    // Tìm kiếm khi gõ
    searchInput.addEventListener("input", function () {
        const query = this.value.trim();
        loadMenu(query);
    });
});
