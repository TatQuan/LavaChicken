document.addEventListener("DOMContentLoaded", function () {
    // Get form elements
    const registerForm = document.getElementById("registerForm");
    const inputs = {
        name: document.getElementById("name"),
        username: document.getElementById("username"),
        email: document.getElementById("email"),
        phone: document.getElementById("phone"),
        password: document.getElementById("password"),
        confirmPassword: document.getElementById("confirm_password")
    };
    
    const errors = {
        name: document.getElementById("name-error"),
        username: document.getElementById("username-error"),
        email: document.getElementById("email-error"),
        phone: document.getElementById("phone-error"),
        password: document.getElementById("password-error"),
        confirmPassword: document.getElementById("confirm-password-error")
    };

    // Validation rules configuration
    const validationRules = {
        name: {
            required: true,
            message: "Name cannot be empty"
        },
        username: {
            required: true,
            message: "Username cannot be empty"
        },
        email: {
            required: true,
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            messages: {
                required: "Email cannot be empty",
                pattern: "Please enter a valid email address"
            }
        },
        phone: {
            required: true,
            pattern: /^\+?\d{10,15}$/,
            messages: {
                required: "Phone number cannot be empty",
                pattern: "Phone number must be between 10 and 15 digits"
            }
        },
        password: {
            required: true,
            minLength: 6,
            hasUppercase: true,
            hasNumber: true,
            messages: {
                required: "Password cannot be empty",
                minLength: "Password must be at least 6 characters",
                hasUppercase: "Password must contain at least one uppercase letter",
                hasNumber: "Password must contain at least one number"
            }
        },
        confirmPassword: {
            required: true,
            matchField: 'password',
            messages: {
                required: "Confirm Password cannot be empty",
                match: "Passwords do not match"
            }
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
        
        const value = input.value.trim();
        
        // Clear previous error if showing errors
        if (showErrors && errors[fieldName]) {
            errors[fieldName].textContent = "";
        }
        
        // Required check
        if (rule.required && !value) {
            if (showErrors) {
                const message = rule.messages?.required || rule.message;
                showError(fieldName, message);
            }
            return false;
        }
        
        // Skip other validations if field is empty and not required
        if (!value) return true;
        
        // Pattern validation
        if (rule.pattern && !rule.pattern.test(value)) {
            if (showErrors) {
                const message = rule.messages?.pattern || "Invalid format";
                showError(fieldName, message);
            }
            return false;
        }
        
        // Minimum length validation
        if (rule.minLength && value.length < rule.minLength) {
            if (showErrors) {
                const message = rule.messages?.minLength || `Minimum ${rule.minLength} characters required`;
                showError(fieldName, message);
            }
            return false;
        }
        
        // Uppercase validation
        if (rule.hasUppercase && !/[A-Z]/.test(value)) {
            if (showErrors) {
                const message = rule.messages?.hasUppercase || "Must contain uppercase letter";
                showError(fieldName, message);
            }
            return false;
        }
        
        // Number validation
        if (rule.hasNumber && !/\d/.test(value)) {
            if (showErrors) {
                const message = rule.messages?.hasNumber || "Must contain a number";
                showError(fieldName, message);
            }
            return false;
        }
        
        // Match field validation (for confirm password)
        if (rule.matchField) {
            const matchInput = inputs[rule.matchField];
            if (matchInput && value !== matchInput.value) {
                if (showErrors) {
                    const message = rule.messages?.match || "Fields do not match";
                    showError(fieldName, message);
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

    // Form submission handler
    registerForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Always prevent default first
        
        const isValid = validateAllFields();
        
        if (isValid) {
            // Fix: Submit the correct form (registerForm, not loginForm)
            registerForm.submit();
            
            // Alternative: Handle with AJAX
            // handleAjaxSubmission();
        }
    });

    // Real-time validation setup
    function setupRealtimeValidation() {
        Object.keys(inputs).forEach(fieldName => {
            const input = inputs[fieldName];
            if (!input) return;
            
            // Clear error on input
            input.addEventListener("input", function() {
                if (errors[fieldName]) {
                    errors[fieldName].textContent = "";
                }
                
                // Real-time validation for password
                if (fieldName === 'password' && input.value) {
                    validateField(fieldName, true);
                }
                
                // Real-time validation for confirm password
                if (fieldName === 'confirmPassword' && input.value) {
                    validateField(fieldName, true);
                }
            });
            
            // Validate on blur for better UX
            input.addEventListener("blur", function() {
                if (input.value.trim()) {
                    validateField(fieldName, true);
                }
            });
        });
    }
    
    // Initialize real-time validation
    setupRealtimeValidation();

    // Optional: AJAX submission handler
    function handleAjaxSubmission() {
        const formData = new FormData(registerForm);
        
        // Show loading state
        const submitButton = registerForm.querySelector('button[type="submit"]');
        const originalText = submitButton?.textContent;
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';
        }
        
        fetch(registerForm.action || '/register', {
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
                // Handle success - redirect or show success message
                window.location.href = data.redirect || '/dashboard';
            } else {
                // Handle validation errors from server
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        if (errors[field]) {
                            errors[field].textContent = data.errors[field];
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Registration failed:', error);
            // Show generic error message
            alert('Registration failed. Please try again.');
        })
        .finally(() => {
            // Restore button state
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        });
    }

    // Additional utility functions for external use
    window.FormValidator = {
        validate: validateAllFields,
        validateField: validateField,
        clearErrors: clearAllErrors
    };
});

// Separate validatePassword function (if you have additional custom validation)
function validatePassword(password) {
    // This function seems to be called in your original code
    // You can implement additional custom password rules here
    
    // Example additional rules:
    if (password.includes('password')) {
        return "Password cannot contain the word 'password'";
    }
    
    if (/(.)\1{2,}/.test(password)) {
        return "Password cannot contain more than 2 consecutive identical characters";
    }
    
    // Return null if password passes all custom rules
    return null;
}