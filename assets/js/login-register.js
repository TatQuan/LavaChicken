document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const usernameError = document.getElementById("username-error");
    const passwordError = document.getElementById("password-error");

    loginForm.addEventListener("submit", function (e) {
        let valid = true;
        usernameError.textContent = "";
        passwordError.textContent = "";

        if (!usernameInput.value.trim()) {
            usernameError.textContent = "Username cannot be empty";
            valid = false;
        }
        if (!passwordInput.value) {
            passwordError.textContent = "Password cannot be empty";
            valid = false;
        } else {
            const pwMsg = validatePassword(passwordInput.value);
            if (pwMsg) {
                passwordError.textContent = pwMsg;
                valid = false;
            }
        }
        if (!valid) 
            loginForm.submit();
    });

    passwordInput.addEventListener("input", function () {
        passwordError.textContent = "";
        if (!passwordInput.value) return;
        const pwMsg = validatePassword(passwordInput.value);
        if (pwMsg) passwordError.textContent = pwMsg;
    });
    usernameInput.addEventListener("input", function () {
        usernameError.textContent = "";
    });
});


