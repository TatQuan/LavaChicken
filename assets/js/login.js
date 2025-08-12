document.addEventListener("DOMContentLoaded", function () {
    // Get form elements
    const loginForm = document.getElementById("loginForm");
    const inputs = {
        username: document.getElementById("username"),
        password: document.getElementById("password")
    };
    
    const errors = {
        username: document.getElementById("username-error"),
        password: document.getElementById("password-error")
    };

    // Validation configuration
    const validationRules = {
        username: {
            required: true,
            message: "Username cannot be empty"
        },
        password: {
            required: true,
            message: "Password cannot be empty"
        }
    };

    // Utility functions
    function clearAllErrors() {
        Object.values(errors).forEach(errorEl => {
            if (errorEl) errorEl.textContent = "";
        });
    }

    function showError(field, message) {
        if (errors[field]) {
            errors[field].textContent = message;
        }
    }

    function validateField(fieldName, showErrors = true) {
        const input = inputs[fieldName];
        const rule = validationRules[fieldName];
        
        if (!input || !rule) return true;
        
        const value = fieldName === 'password' ? input.value : input.value.trim();
        
        // Clear previous error
        if (showErrors && errors[fieldName]) {
            errors[fieldName].textContent = "";
        }
        
        // Required validation
        if (rule.required && !value) {
            if (showErrors) {
                showError(fieldName, rule.message);
            }
            return false;
        }
        
        // Custom password validation (if validatePassword function exists)
        if (fieldName === 'password' && value && typeof validatePassword === 'function') {
            const customError = validatePassword(value);
            if (customError) {
                if (showErrors) {
                    showError(fieldName, customError);
                }
                return false;
            }
        }
        
        return true;
    }

    function validateAllFields() {
        clearAllErrors();
        let isValid = true;
        
        // Validate all fields
        Object.keys(validationRules).forEach(fieldName => {
            if (!validateField(fieldName, true)) {
                isValid = false;
            }
        });
        
        return isValid;
    }

    // Form submission handler - FIXED CRITICAL BUG
    loginForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Always prevent default first
        
        const isValid = validateAllFields();
        
        // CRITICAL FIX: Submit only if valid (not if invalid!)
        if (isValid) {
            // Option 1: Regular form submission
            loginForm.submit();
            
            // Option 2: AJAX submission (uncomment if needed)
            // handleAjaxLogin();
        }
        // If invalid, form won't submit (prevented by e.preventDefault())
    });

    // Real-time validation setup
    function setupRealtimeValidation() {
        Object.keys(inputs).forEach(fieldName => {
            const input = inputs[fieldName];
            if (!input) return;
            
            input.addEventListener("input", function() {
                // Clear error immediately when user starts typing
                if (errors[fieldName]) {
                    errors[fieldName].textContent = "";
                }
                
                // Real-time validation for password (if not empty)
                if (fieldName === 'password' && input.value) {
                    validateField(fieldName, true);
                }
            });
            
            // Validate on blur for better UX
            input.addEventListener("blur", function() {
                if (input.value.trim() || fieldName === 'password' && input.value) {
                    validateField(fieldName, true);
                }
            });
        });
    }
    
    // Initialize real-time validation
    setupRealtimeValidation();

    // Optional: AJAX login handler
    function handleAjaxLogin() {
        const formData = new FormData(loginForm);
        
        // Show loading state
        const submitButton = loginForm.querySelector('button[type="submit"]') || 
                           loginForm.querySelector('input[type="submit"]');
        const originalText = submitButton?.textContent || submitButton?.value;
        
        if (submitButton) {
            submitButton.disabled = true;
            if (submitButton.textContent !== undefined) {
                submitButton.textContent = 'Logging in...';
            } else {
                submitButton.value = 'Logging in...';
            }
        }
        
        fetch(loginForm.action || '/login', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Handle successful login
                window.location.href = data.redirect || '/dashboard';
            } else {
                // Handle login errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        if (errors[field]) {
                            errors[field].textContent = data.errors[field];
                        }
                    });
                } else if (data.message) {
                    // General error message
                    showError('username', data.message);
                }
            }
        })
        .catch(error => {
            console.error('Login failed:', error);
            // Show user-friendly error
            showError('username', 'Login failed. Please check your connection and try again.');
        })
        .finally(() => {
            // Restore button state
            if (submitButton) {
                submitButton.disabled = false;
                if (submitButton.textContent !== undefined) {
                    submitButton.textContent = originalText;
                } else {
                    submitButton.value = originalText;
                }
            }
        });
    }

    // Utility functions for external access
    window.LoginValidator = {
        validate: validateAllFields,
        validateField: validateField,
        clearErrors: clearAllErrors,
        showError: showError
    };
});

// Enhanced validatePassword function (if you need it)
function validatePassword(password) {
    // Basic security checks for login
    if (password.length < 3) {
        return "Password too short";
    }
    
    // You can add more custom rules here
    // For login, usually we don't validate complexity
    // as user might have old passwords
    
    return null; // Valid
}

// Alternative: Simpler version without configuration
function simpleLoginValidation() {
    document.addEventListener("DOMContentLoaded", function () {
        const loginForm = document.getElementById("loginForm");
        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("password");
        const usernameError = document.getElementById("username-error");
        const passwordError = document.getElementById("password-error");

        if (!loginForm) return;

        loginForm.addEventListener("submit", function (e) {
            e.preventDefault(); // CRITICAL: Always prevent default first
            
            let valid = true;
            
            // Clear errors
            usernameError.textContent = "";
            passwordError.textContent = "";

            // Validate username
            if (!usernameInput.value.trim()) {
                usernameError.textContent = "Username cannot be empty";
                valid = false;
            }

            // Validate password
            if (!passwordInput.value) {
                passwordError.textContent = "Password cannot be empty";
                valid = false;
            } else if (typeof validatePassword === 'function') {
                const pwMsg = validatePassword(passwordInput.value);
                if (pwMsg) {
                    passwordError.textContent = pwMsg;
                    valid = false;
                }
            }

            // CRITICAL FIX: Submit only if valid
            if (valid) {
                loginForm.submit();
            }
        });

        // Real-time error clearing
        usernameInput.addEventListener("input", function () {
            usernameError.textContent = "";
        });

        passwordInput.addEventListener("input", function () {
            passwordError.textContent = "";
            // Optional: Real-time password validation
            if (passwordInput.value && typeof validatePassword === 'function') {
                const pwMsg = validatePassword(passwordInput.value);
                if (pwMsg) passwordError.textContent = pwMsg;
            }
        });
    });
}

// Uncomment to use simple version instead
// simpleLoginValidation();