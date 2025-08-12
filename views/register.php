<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/register.css"/>
    <script src="assets/js/register.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&display=swap">
</head>
<body>

    <div class="register-container">

        <form class="register-box" id="registerForm" action="index.php?controller=Register&action=register" method="POST">

            <h2>Create Your Account</h2>

            <hr class="underline" />

            <div class="input-group">

                <input type="text" name="name" id="name" placeholder="Enter your name"/>
                <div class="error-msg" id="name-error"></div>

                <input type="text" name="username" id="username" placeholder="Enter your username"/>
                <div class="error-msg" id="username-error"></div>

                <input type="email" name="email" id="email" placeholder="Enter your email"/>
                <div class="error-msg" id="email-error"></div>

                <input type="text" name="phone" id="phone" placeholder="Enter your phone number"/>
                <div class="error-msg" id="phone-error"></div>

                <input type="password" name="password" id="password" placeholder="Enter your password"/>
                <div class="error-msg" id="password-error"></div>

                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password"/>
                <div class="error-msg" id="confirm-password-error"></div>

            </div>

            <button type="submit">Register</button>

            <div class="links">
                <label>Already have an account?</label>
                <a href="./index.php?controller=Login&action=index">Login</a> | 
            </div>

        </form>
    </div>

    <div id="custom-alert" class="custom-alert hidden">
        <p id="custom-alert-message"></p>
        <button onclick="closeCustomAlert()">OK</button>
    </div>
</body>
</html>
        <p id="custom-alert-message"></p>
        <button onclick="closeCustomAlert()">OK</button>
    </div>
</body>
</html>

<?php if (isset($error_email) || isset($error_username)): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            <?php if (isset($error_email)): ?>
                document.getElementById("email-error").textContent = "<?php echo addslashes($error_email); ?>";
            <?php endif; ?>

            <?php if (isset($error_username)): ?>
                document.getElementById("username-error").textContent = "<?php echo addslashes($error_username); ?>";
            <?php endif; ?>
        });
    </script>
<?php endif; ?>