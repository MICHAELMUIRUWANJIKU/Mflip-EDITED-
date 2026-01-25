<?php
// Get current page for active menu styling
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>MflipAdventures & Safaris</title>
    
    <!-- All CSS files in one place -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Page-specific CSS -->
    <?php if (file_exists('assets/css/' . $current_page . '.css')): ?>
    <link rel="stylesheet" href="assets/css/<?php echo $current_page; ?>.css">
    <?php endif; ?>
    
    <!-- Page-specific additional CSS -->
    <?php if (isset($additional_css)): ?>
    <?php foreach ($additional_css as $css): ?>
    <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php endforeach; ?>
    <?php endif; ?>
    
    <link rel="icon" type="image/x-icon" href="assets/images/logo/favicon.ico">
</head>
<body>
    <!-- Header & Navigation -->
    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php">
                        <img class="logo1" src="assets/images/mflip_logo.jpeg">

                    </a>
                </div>
                
                <ul class="nav-menu">
                    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="tours.php" class="<?php echo ($current_page == 'tours.php') ? 'active' : ''; ?>">Tours</a></li>
                    <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="gallery.php" class="<?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
                    <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                    <li><a href="booking.php" class="btn-book">Book Now</a></li>
                </ul>
                
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </div>
    </header>