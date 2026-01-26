<?php
/**
 * MflipAdventures & Safaris - Authentication System
 * Secure authentication and authorization functions
 */

session_start();

/**
 * Check if admin is logged in
 * Redirects to login page if not authenticated
 */
function checkAdminLogin() {
    // First check session
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        return true;
    }
    
    // Then check remember me cookie
    if (isset($_COOKIE['admin_remember'])) {
        global $conn;
        $token = $_COOKIE['admin_remember'];
        
        // Validate token in database
        $sql = "SELECT id, username, email, full_name, role FROM admin_users 
                WHERE remember_token = ? AND remember_token IS NOT NULL";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Token is valid, log user in
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_name'] = $row['full_name'];
            $_SESSION['admin_role'] = $row['role'];
            
            // Update last login
            $update_sql = "UPDATE admin_users SET last_login = NOW() WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, 'i', $row['id']);
            mysqli_stmt_execute($update_stmt);
            
            return true;
        } else {
            // Invalid token, clear cookie
            setcookie('admin_remember', '', time() - 3600, '/');
        }
    }
    
    // Not authenticated, redirect to login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: ../admin/login.php');
    exit;
}

/**
 * Check if user is logged in (returns boolean)
 */
function isLoggedIn() {
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        return true;
    }
    
    // Check remember me cookie
    if (isset($_COOKIE['admin_remember'])) {
        global $conn;
        $token = $_COOKIE['admin_remember'];
        
        $sql = "SELECT id FROM admin_users WHERE remember_token = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_num_rows($result) > 0;
    }
    
    return false;
}

/**
 * Get current admin user data
 */
function getCurrentAdmin() {
    if (isset($_SESSION['admin_id'])) {
        return [
            'id' => $_SESSION['admin_id'],
            'username' => $_SESSION['admin_username'],
            'email' => $_SESSION['admin_email'],
            'name' => $_SESSION['admin_name'],
            'role' => $_SESSION['admin_role']
        ];
    }
    return null;
}

/**
 * Check if current user has specific role
 */
function hasRole($required_role) {
    if (!isset($_SESSION['admin_role'])) {
        return false;
    }
    
    $roles = ['viewer', 'editor', 'admin'];
    $current_role_index = array_search($_SESSION['admin_role'], $roles);
    $required_role_index = array_search($required_role, $roles);
    
    return $current_role_index >= $required_role_index;
}

/**
 * Require specific role (redirects if not authorized)
 */
function requireRole($required_role) {
    if (!hasRole($required_role)) {
        $_SESSION['error_message'] = 'You do not have permission to access this page.';
        header('Location: ../admin/index.php');
        exit;
    }
}

/**
 * Check if user can perform action on resource
 */
function canPerformAction($action, $resource = null) {
    $admin = getCurrentAdmin();
    if (!$admin) return false;
    
    switch ($admin['role']) {
        case 'admin':
            return true; // Admin can do everything
            
        case 'editor':
            $allowed_actions = ['view', 'create', 'edit', 'delete_own'];
            $allowed_resources = ['tours', 'bookings', 'pages'];
            return in_array($action, $allowed_actions);
            
        case 'viewer':
            $allowed_actions = ['view'];
            return in_array($action, $allowed_actions);
            
        default:
            return false;
    }
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

/**
 * Secure logout function
 */
function secureLogout() {
    global $conn;
    
    // Clear remember token from database
    if (isset($_SESSION['admin_id'])) {
        $sql = "UPDATE admin_users SET remember_token = NULL WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['admin_id']);
        mysqli_stmt_execute($stmt);
    }
    
    // Clear session data
    $_SESSION = array();
    
    // Destroy session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    // Destroy session
    session_destroy();
    
    // Clear remember me cookie
    setcookie('admin_remember', '', time() - 3600, '/');
}

/**
 * Check for brute force protection
 */
function checkBruteForce($username, $max_attempts = 5, $lockout_time = 900) {
    global $conn;
    
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $now = time();
    
    // Get failed attempts in last lockout period
    $sql = "SELECT COUNT(*) as attempts FROM login_attempts 
            WHERE username = ? OR ip_address = ? 
            AND timestamp > DATE_SUB(NOW(), INTERVAL ? SECOND)";
    $stmt = mysqli_prepare($conn, $sql);
    $lockout_minutes = $lockout_time / 60;
    mysqli_stmt_bind_param($stmt, 'ssi', $username, $ip_address, $lockout_minutes);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    return $data['attempts'] >= $max_attempts;
}

/**
 * Record failed login attempt
 */
function recordFailedAttempt($username) {
    global $conn;
    
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    $sql = "INSERT INTO login_attempts (username, ip_address, user_agent) 
            VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $username, $ip_address, $user_agent);
    mysqli_stmt_execute($stmt);
}

/**
 * Clear failed attempts for user
 */
function clearFailedAttempts($username) {
    global $conn;
    
    $sql = "DELETE FROM login_attempts WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
}

/**
 * Generate secure random password
 */
function generateSecurePassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    $password = '';
    $charLength = strlen($chars) - 1;
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $charLength)];
    }
    
    return $password;
}

/**
 * Password strength checker
 */
function checkPasswordStrength($password) {
    $strength = 0;
    $messages = [];
    
    // Length check
    if (strlen($password) >= 8) $strength += 1;
    else $messages[] = 'Password should be at least 8 characters long';
    
    // Contains lowercase
    if (preg_match('/[a-z]/', $password)) $strength += 1;
    else $messages[] = 'Password should contain at least one lowercase letter';
    
    // Contains uppercase
    if (preg_match('/[A-Z]/', $password)) $strength += 1;
    else $messages[] = 'Password should contain at least one uppercase letter';
    
    // Contains number
    if (preg_match('/[0-9]/', $password)) $strength += 1;
    else $messages[] = 'Password should contain at least one number';
    
    // Contains special character
    if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) $strength += 1;
    else $messages[] = 'Password should contain at least one special character';
    
    // Return strength score and messages
    return [
        'score' => $strength,
        'max_score' => 5,
        'strength' => $strength <= 2 ? 'Weak' : ($strength <= 4 ? 'Medium' : 'Strong'),
        'messages' => $messages
    ];
}

/**
 * Send password reset email
 */
function sendPasswordResetEmail($email, $token) {
    // In production, use PHPMailer or similar
    $reset_link = "https://" . $_SERVER['HTTP_HOST'] . "/admin/reset-password.php?token=" . urlencode($token);
    
    $subject = "Password Reset Request - MflipAdventures Admin";
    $message = "
    <html>
    <head>
        <title>Password Reset</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #2E8B57; color: white; padding: 20px; text-align: center; }
            .content { padding: 30px; background-color: #f9f9f9; }
            .button { display: inline-block; background-color: #2E8B57; color: white; 
                     padding: 12px 30px; text-decoration: none; border-radius: 5px; 
                     margin: 20px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>MflipAdventures & Safaris</h1>
                <h2>Admin Password Reset</h2>
            </div>
            <div class='content'>
                <p>Hello,</p>
                <p>We received a request to reset your password for the MflipAdventures admin panel.</p>
                <p>Click the button below to reset your password:</p>
                <p style='text-align: center;'>
                    <a href='$reset_link' class='button'>Reset Password</a>
                </p>
                <p>If you didn't request this, please ignore this email or contact support if you have concerns.</p>
                <p><strong>Note:</strong> This link will expire in 1 hour.</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " MflipAdventures & Safaris. All rights reserved.</p>
                <p>This is an automated message, please do not reply to this email.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: MflipAdventures Admin <no-reply@" . $_SERVER['HTTP_HOST'] . ">" . "\r\n";
    
    return mail($email, $subject, $message, $headers);
}

/**
 * Log user activity
 */
function logActivity($user_id, $action, $details = '') {
    global $conn;
    
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $page_url = $_SERVER['REQUEST_URI'];
    
    $sql = "INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent, page_url) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isssss', $user_id, $action, $details, $ip_address, $user_agent, $page_url);
    
    try {
        mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        // Log to file if database fails
        error_log("Activity Log Error: " . $e->getMessage());
    }
    
    mysqli_stmt_close($stmt);
}

/**
 * Get user permissions for UI display
 */
function getUserPermissions() {
    $admin = getCurrentAdmin();
    if (!$admin) return [];
    
    $permissions = [
        'dashboard' => true,
        'view_tours' => true,
        'view_bookings' => true,
        'view_users' => false,
        'view_reports' => false
    ];
    
    switch ($admin['role']) {
        case 'admin':
            $permissions = array_merge($permissions, [
                'create_tours' => true,
                'edit_tours' => true,
                'delete_tours' => true,
                'edit_bookings' => true,
                'delete_bookings' => true,
                'view_users' => true,
                'edit_users' => true,
                'delete_users' => true,
                'view_reports' => true,
                'manage_settings' => true
            ]);
            break;
            
        case 'editor':
            $permissions = array_merge($permissions, [
                'create_tours' => true,
                'edit_tours' => true,
                'delete_tours' => false,
                'edit_bookings' => true,
                'delete_bookings' => false,
                'view_reports' => true
            ]);
            break;
            
        case 'viewer':
            // Viewer can only view
            break;
    }
    
    return $permissions;
}

/**
 * Check permission for UI elements
 */
function hasPermission($permission) {
    $permissions = getUserPermissions();
    return isset($permissions[$permission]) && $permissions[$permission] === true;
}

/**
 * Secure input sanitization
 */
function sanitizeInput($input) {
    global $conn;
    
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    
    if (isset($conn)) {
        $input = mysqli_real_escape_string($conn, $input);
    }
    
    return $input;
}

/**
 * Generate secure file upload name
 */
function generateSecureFileName($original_name) {
    $extension = pathinfo($original_name, PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(16));
    return $basename . '.' . $extension;
}

/**
 * Check if request is AJAX
 */
function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Return JSON response
 */
function jsonResponse($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Redirect with flash message
 */
function redirectWithMessage($url, $type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
    header("Location: $url");
    exit;
}

/**
 * Display flash message
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        
        $alert_class = $message['type'] === 'success' ? 'alert-success' : 'alert-error';
        
        echo '<div class="alert ' . $alert_class . '">' . 
             '<i class="fas fa-' . ($message['type'] === 'success' ? 'check' : 'exclamation') . '-circle"></i> ' .
             htmlspecialchars($message['message']) . 
             '</div>';
    }
}

// Auto-check login for admin pages
if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false && 
    basename($_SERVER['PHP_SELF']) !== 'login.php' &&
    basename($_SERVER['PHP_SELF']) !== 'login_logic.php' &&
    basename($_SERVER['PHP_SELF']) !== 'logout.php') {
    
    if (!isLoggedIn()) {
        checkAdminLogin();
    }
}
?>