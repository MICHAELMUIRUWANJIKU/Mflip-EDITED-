<?php
// database.php - Database connection

$host = 'localhost';
$username = 'root'; // Change if different
$password = ''; // Your MySQL password
$database = 'mflip_adventures';

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Function to sanitize input
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}

// Function to display errors (development only)
function displayError($message) {
    if (isset($_SESSION['admin'])) {
        echo '<div class="alert alert-error">' . $message . '</div>';
    }
}
?>