const searchBtn = document.getElementById('search-btn');
const popup = document.getElementById('popup');
const closePopup = document.getElementById('close-popup');
const popupText = document.getElementById('popup-text');

searchBtn.addEventListener('click', () => {
    const address = document.getElementById('address').value.trim();
    if (address === "") {
        alert("Please enter a shipping address!");
        return;
    }
    popupText.textContent = `Tracking info for: ${address}`;
    popup.style.display = 'block';
});

closePopup.addEventListener('click', () => {
    popup.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if (e.target === popup) {
        popup.style.display = 'none';
    }
});
