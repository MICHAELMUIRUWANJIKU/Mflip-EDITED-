<?php
session_start();
// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$page_title = 'Admin Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | MflipAdventures</title>
    <link rel="stylesheet" href="assets/css/admin_login.css">
    <link rel="stylesheet" href="assets/css/admin_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/images/logo/favicon.ico">
</head>
<body class="login-page">
    <!-- Login Container -->
    <div class="login-container">
        <!-- Left Panel - Branding -->
        <div class="login-left-panel">
            <div class="brand-logo">
                <h1>Mflip<span>Adventures</span></h1>
                <p class="tagline">& Safaris Admin</p>
            </div>
            
            <div class="login-illustration">
                <div class="illustration-circle"></div>
                <div class="illustration-circle"></div>
                <div class="illustration-circle"></div>
                <i class="fas fa-lock"></i>
            </div>
            
            <div class="login-features">
                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure Access</h3>
                    <p>Protected admin dashboard with encryption</p>
                </div>
                <div class="feature">
                    <i class="fas fa-chart-line"></i>
                    <h3>Analytics</h3>
                    <p>Track bookings and tour performance</p>
                </div>
                <div class="feature">
                    <i class="fas fa-cogs"></i>
                    <h3>Management</h3>
                    <p>Full control over tours and bookings</p>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Login Form -->
        <div class="login-right-panel">
            <div class="login-form-container">
                <div class="login-header">
                    <h2>Admin Portal</h2>
                    <p>Sign in to manage your safari tours</p>
                </div>
                
                <?php
                // Display error messages
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="alert alert-error">' . $_SESSION['login_error'] . '</div>';
                    unset($_SESSION['login_error']);
                }
                
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }
                ?>
                
                <form id="loginForm" class="login-form" action="login_logic.php" method="POST">
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" id="username" name="username" required 
                               placeholder="Enter your username" 
                               value="<?php echo isset($_SESSION['login_username']) ? $_SESSION['login_username'] : ''; ?>"
                               autocomplete="username">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" required 
                                   placeholder="Enter your password"
                                   autocomplete="current-password">
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email (Optional)
                        </label>
                        <input type="email" id="email" name="email" 
                               placeholder="Enter your email for notifications"
                               value="<?php echo isset($_SESSION['login_email']) ? $_SESSION['login_email'] : ''; ?>"
                               autocomplete="email">
                    </div>
                    
                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                        <a href="forgot-password.php" class="forgot-password">
                            Forgot Password?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn-login" id="loginButton">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                    
                    <div class="login-divider">
                        <span>or</span>
                    </div>
                    
                    <div class="alternative-login">
                        <p>Need help accessing your account?</p>
                        <a href="mailto:support@mflipadventures.com" class="btn-support">
                            <i class="fas fa-headset"></i> Contact Support
                        </a>
                    </div>
                </form>
                
                <div class="login-footer">
                    <p>&copy; <?php echo date('Y'); ?> MflipAdventures & Safaris</p>
                    <p><a href="../index.php" class="back-to-site">
                        <i class="fas fa-arrow-left"></i> Back to Website
                    </a></p>
                </div>
            </div>
            
            <!-- Security Tips -->
            <div class="security-tips">
                <h4><i class="fas fa-lightbulb"></i> Security Tips</h4>
                <ul>
                    <li>Never share your login credentials</li>
                    <li>Use a strong, unique password</li>
                    <li>Log out when using shared computers</li>
                    <li>Enable 2FA if available</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Authenticating...</p>
        </div>
    </div>
    
    <script src="assets/js/admin-login.js"></script>
</body>
</html>
<?php
// Clear session variables
unset($_SESSION['login_username']);
unset($_SESSION['login_email']);
?>