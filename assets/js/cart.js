(function(){
  const $ = s => document.querySelector(s);
  const TAX = 0.1;

  function loadCart(){
    return JSON.parse(localStorage.getItem('lava_cart') || '[]');
  }

  function saveCart(cart){
    localStorage.setItem('lava_cart', JSON.stringify(cart));
  }

  function money(n){ return "$" + n.toFixed(2); }

  function render(){
    const items = loadCart();
    const count = items.reduce((t, i) => t + i.qty, 0);
    $(".count").textContent = `(${count} item${count >= 2 ? 's' : ''})`;

    const cartEmpty = $("#cart-empty");
    const cartSection = $("#cart-section");
    const cartItems = $("#cart-items");

    if(items.length === 0){
      cartSection.classList.add("hidden");
      cartEmpty.classList.remove("hidden");
      return;
    }

    cartSection.classList.remove("hidden");
    cartEmpty.classList.add("hidden");

    cartItems.innerHTML = "";
    let total = 0;

    items.forEach((item, idx) => {
      const itemTotal = item.price * item.qty;
      total += itemTotal;

      const row = document.createElement("div");
      row.className = "row";
      row.innerHTML = `
        <div class="col item">
          <img class="thumb" src="${item.image}" alt="">
          <div>${item.name}</div>
        </div>
        <div class="col price">${money(item.price)}</div>
        <div class="col qty">
          <div class="qty-controls" data-idx="${idx}">
            <button class="decr">-</button>
            <input class="qty" type="text" value="${item.qty}" min="1">
            <button class="incr">+</button>
          </div>
        </div>
        <div class="col total">${money(itemTotal)}</div>
        <div class="col remove">
          <button class="remove-btn" data-idx="${idx}">✕</button>
        </div>`;
      cartItems.appendChild(row);
    });

    $("#grand").textContent = money(total);
  }

  document.addEventListener("click", e => {
    if(e.target.classList.contains("incr") || e.target.classList.contains("decr")){
      const idx = e.target.closest(".qty-controls").dataset.idx;
      const cart = loadCart();
      if(e.target.classList.contains("incr")) cart[idx].qty++;
      else cart[idx].qty = Math.max(1, cart[idx].qty - 1);
      saveCart(cart); render();
    }

    if(e.target.classList.contains("remove-btn")){
      const idx = e.target.dataset.idx;
      const cart = loadCart();
      cart.splice(idx, 1);
      saveCart(cart); render();
    }

    if(e.target.id === "continue-shopping") {
      window.location.href = "menu.html";
    }
  });

  document.addEventListener("input", e => {
    if(e.target.classList.contains("qty")){
      const idx = e.target.closest(".qty-controls").dataset.idx;
      const cart = loadCart();
      cart[idx].qty = Math.max(1, parseInt(e.target.value || 1));
      saveCart(cart); render();
    }
  });

  render();
})();
