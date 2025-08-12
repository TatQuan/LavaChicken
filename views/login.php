<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css"/>
    <script src="assets/js/login.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&display=swap">
</head>
<body>
    <div class="login-container">

        <form class="login-box" id="loginForm" action="index.php?controller=Login&action=login" method="POST">

            <h2>Login</h2>

            <hr class="underline" />

            <?php if (isset($login_error)): ?>
                <div class="error-msg" style="text-align: center;"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <?php if (isset($message)): ?>
                <div style="color:green; margin-top:10px;"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="input-group">

                <input type="text" name="username" id="username" placeholder="Enter your username"/>
                <div class="error-msg" id="username-error"></div>

                <input type="password" name="password" id="password" placeholder="Enter your password" />
                <div class="error-msg" id="password-error"></div>

            </div>

            <button type="submit">Login</button>

            <div class="links">
                <a href="./index.php?controller=Register&action=index">Sign Up</a> | 
                <a href="#">Forgot Password</a>
            </div>

        </form>
    </div>
</body>
</html>

