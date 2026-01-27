<?php
session_start();
require_once '../includes/database.php';

// Set headers
header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and sanitize input
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$remember = isset($_POST['remember']) ? true : false;

// Validate input
$errors = [];

if (empty($username)) {
    $errors['username'] = 'Username is required';
}

if (empty($password)) {
    $errors['password'] = 'Password is required';
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format';
}

// If there are errors
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => 'Validation failed',
        'errors' => $errors
    ]);
    exit;
}

// Prepare SQL statement to prevent SQL injection
$sql = "SELECT id, username, email, password_hash
        FROM admin_users 
        WHERE username = ? OR email = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'ss', $username, $username);
    
    // Execute statement
    mysqli_stmt_execute($stmt);
    
    // Get result
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Verify password
        if (password_verify($password, $row['password_hash'])) {
            // Password is correct
            
            
            // Set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_email'] = $row['email'];
            
            // If "remember me" is checked, set cookie
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days
                
                // Store token in database
                $token_sql = "UPDATE admin_users SET remember_token = ? WHERE id = ?";
                $token_stmt = mysqli_prepare($conn, $token_sql);
                mysqli_stmt_bind_param($token_stmt, 'si', $token, $row['id']);
                mysqli_stmt_execute($token_stmt);
                
                // Set cookie
                setcookie('admin_remember', $token, $expiry, '/', '', true, true);
            }
            
            // Log login activity
            logActivity($row['id'], 'Login', 'User logged in successfully');
            
            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => 'index.php'
            ]);
            
        } else {
            // Password is incorrect
            logActivity(null, 'Failed Login', "Failed login attempt for username: $username");
            
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username or password'
            ]);
        }
    } else {
        // User not found
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    // SQL error
    error_log("Login SQL error: " . mysqli_error($conn));
    echo json_encode([
        'success' => false,
        'message' => 'System error. Please try again later.'
    ]);
}

// Close connection
mysqli_close($conn);

/**
 * Log activity to database
 */
function logActivity($user_id, $action, $details) {
    global $conn;
    
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    $sql = "INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'issss', $user_id, $action, $details, $ip_address, $user_agent);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>