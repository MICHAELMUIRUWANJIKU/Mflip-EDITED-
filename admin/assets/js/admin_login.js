// Admin Login JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('loginButton');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    
    // Toggle password visibility
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
    
    // Form submission with AJAX
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateForm()) {
                return;
            }
            
            // Show loading overlay
            loadingOverlay.classList.add('active');
            loginButton.disabled = true;
            loginButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
            
            // Get form data
            const formData = new FormData(this);
            
            // Send AJAX request
            fetch('login_logic.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading overlay
                loadingOverlay.classList.remove('active');
                loginButton.disabled = false;
                loginButton.innerHTML = '<i class="fas fa-sign-in-alt"></i> Sign In';
                
                if (data.success) {
                    // Show success message
                    showMessage('success', data.message);
                    
                    // Redirect after delay
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    // Show error message
                    showMessage('error', data.message);
                    
                    // Highlight error fields
                    if (data.errors) {
                        highlightErrors(data.errors);
                    }
                }
            })
            .catch(error => {
                // Hide loading overlay
                loadingOverlay.classList.remove('active');
                loginButton.disabled = false;
                loginButton.innerHTML = '<i class="fas fa-sign-in-alt"></i> Sign In';
                
                showMessage('error', 'Network error. Please check your connection.');
                console.error('Error:', error);
            });
        });
    }
    
    // Real-time validation
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            validateUsername(this.value);
        });
    }
    
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            validateEmail(this.value);
        });
    }
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            validatePassword(this.value);
        });
    }
    
    // Auto-generate slug from username on blur
    if (usernameInput) {
        usernameInput.addEventListener('blur', function() {
            if (this.value && !emailInput.value) {
                emailInput.value = this.value + '@mflipadventures.com';
            }
        });
    }
    
    // Form validation functions
    function validateForm() {
        let isValid = true;
        
        // Validate username
        if (!validateUsername(usernameInput.value)) {
            isValid = false;
        }
        
        // Validate password
        if (!validatePassword(passwordInput.value)) {
            isValid = false;
        }
        
        // Validate email (optional)
        if (emailInput.value && !validateEmail(emailInput.value)) {
            isValid = false;
        }
        
        return isValid;
    }
    
    function validateUsername(username) {
        const usernameError = document.getElementById('usernameError');
        
        if (!username) {
            showFieldError(usernameInput, 'Username is required');
            return false;
        }
        
        if (username.length < 3) {
            showFieldError(usernameInput, 'Username must be at least 3 characters');
            return false;
        }
        
        if (username.length > 50) {
            showFieldError(usernameInput, 'Username is too long (max 50 characters)');
            return false;
        }
        
        clearFieldError(usernameInput);
        return true;
    }
    
    function validatePassword(password) {
        if (!password) {
            showFieldError(passwordInput, 'Password is required');
            return false;
        }
        
        if (password.length < 6) {
            showFieldError(passwordInput, 'Password must be at least 6 characters');
            return false;
        }
        
        clearFieldError(passwordInput);
        return true;
    }
    
    function validateEmail(email) {
        if (!email) return true; // Email is optional
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!emailRegex.test(email)) {
            showFieldError(emailInput, 'Please enter a valid email address');
            return false;
        }
        
        clearFieldError(emailInput);
        return true;
    }
    
    function showFieldError(input, message) {
        // Remove any existing error
        clearFieldError(input);
        
        // Add error class to input
        input.classList.add('error');
        
        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.color = '#c62828';
        errorDiv.style.fontSize = '0.85rem';
        errorDiv.style.marginTop = '5px';
        
        // Insert after input
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
    }
    
    function clearFieldError(input) {
        input.classList.remove('error');
        
        // Remove error message
        const errorDiv = input.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
    
    function highlightErrors(errors) {
        // Clear all errors first
        clearAllErrors();
        
        // Highlight each error
        for (const field in errors) {
            const input = document.getElementById(field);
            if (input) {
                showFieldError(input, errors[field]);
            }
        }
    }
    
    function clearAllErrors() {
        const inputs = document.querySelectorAll('.form-group input');
        inputs.forEach(input => clearFieldError(input));
    }
    
    function showMessage(type, message) {
        // Remove any existing message
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        
        // Add icon based on type
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        alertDiv.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
        
        // Insert after login header
        const loginHeader = document.querySelector('.login-header');
        if (loginHeader) {
            loginHeader.parentNode.insertBefore(alertDiv, loginHeader.nextSibling);
        }
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 300);
            }
        }, 5000);
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + Enter to submit form
        if (e.ctrlKey && e.key === 'Enter') {
            if (loginForm) {
                loginForm.dispatchEvent(new Event('submit'));
            }
        }
        
        // Escape to focus username
        if (e.key === 'Escape') {
            usernameInput.focus();
        }
    });
    
    // Add animation to form on load
    setTimeout(() => {
        document.querySelectorAll('.form-group').forEach((group, index) => {
            group.style.animationDelay = `${index * 0.1}s`;
        });
    }, 100);
});