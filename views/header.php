<header>
    <nav class="nav">
        <div>
            <a class="logo" href="index.php?controller=Home&action=index" class="logo"><img src="https://i.postimg.cc/WzPbqX8H/Borcelle-removebg-preview.png" alt="Logo"></a>
        </div>
        <ul>
            <li><a href="index.php?controller=Home&action=index">Home</a></li>
            <li><a href="index.php?controller=Menu&action=index">Menu</a></li>
            <li><a href="index.php?controller=Order&action=index">Order</a></li>
            <li><a href="index.php?controller=Combo&action=index">Combo</a></li>
        </ul>
        <div class="header-user">
            <span id="userGreeting" class="hidden"></span>
            <a href="index.php?controller=Login&action=index" class="login-button" onclick="openLogin()">
                <img src="https://img.icons8.com/?size=100&id=ckaioC1qqwCu&format=png&color=FFFFFF" alt="User">
            </a>
            <?php if (isset($_SESSION['user'])): ?>
                <span class="user-name"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <a href="index.php?controller=Login&action=logout" class="logout-button">Logout</a>
            <?php endif; ?>
            <a href="index.php?controller=Cart&action=view" class="cart-icon">
                <img src="https://img.icons8.com/?size=100&id=ii6Lr4KivOiE&format=png&color=FFFFFF" alt="Cart">
            </a>
        </div>
    </nav>
</header>
<?php if (isset($_SESSION['login_success'])): ?>
<div id="login-success-message" style="background:#27ae60;color:#fff;padding:10px 20px;text-align:center;">
    <?= $_SESSION['login_success']; unset($_SESSION['login_success']); ?>
</div>

<script>
    // Auto hide message after 5 seconds
    setTimeout(function() {
        var msg = document.getElementById('login-success-message');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 5000); // 5000 milliseconds = 5 seconds
</script>
<?php endif; ?>