<?php
// Start session for potential user data
session_start();

// Database configuration


// Get company info from database (if available)
$companyInfo = [
    'name' => 'MflipAdventures & Safaris',
    'founded' => 2019,
    'location' => 'Nairobi, Kenya',
    'mission' => 'To provide authentic, sustainable, and life-changing safari experiences that showcase Kenya\'s natural wonders while supporting conservation and community development.',
    'description' => 'Based in the heart of Nairobi, Kenya, MflipAdventures & Safaris was founded in 2015 with a simple mission: to share the breathtaking beauty of East Africa with the world while creating meaningful connections between travelers and local communities.'
];

// Get team members from database (example data - in real app, fetch from DB)
$teamMembers = [
    [
        'name' => ' "Mflip" ',
        'position' => 'Founder',
        'bio' => 'With 7+ years of safari experience, Mflips passion for wildlife conservation and community development drives our company\'s mission. Born and raised in Kenya, he knows every corner of our beautiful country.',
        'qualifications' => ['KPSGA Silver Level Guide', 'Speaks 5 local languages'],
        'image' => 'nature.jpeg'
    ],
    
];

// Get company stats (could be from database)
$companyStats = [
    ['value' => 2019, 'label' => 'Year Founded'],
    ['value' => 2000, 'label' => 'Happy Travelers'],
    ['value' => 15, 'label' => 'Expert Guides'],
    ['value' => 30, 'label' => 'Countries Served']
];

// Get core values
$coreValues = [
    [
        'title' => 'Sustainability',
        'description' => 'We practice and promote eco-friendly tourism, minimize our environmental footprint, and support conservation initiatives across Kenya.',
        'icon' => 'leaf'
    ],
    [
        'title' => 'Community',
        'description' => '5% of all profits are reinvested in local communities through education, healthcare, and sustainable livelihood projects.',
        'icon' => 'hands-helping'
    ],
    [
        'title' => 'Excellence',
        'description' => 'From vehicle maintenance to guide training, we maintain the highest standards to ensure your safety and satisfaction.',
        'icon' => 'award'
    ],
    [
        'title' => 'Authenticity',
        'description' => 'We believe in genuine experiences - not tourist traps. Our tours connect you with real Kenya, its people, and its wildlife.',
        'icon' => 'heart'
    ]
];

// Set page title for header
$pageTitle = "About Us - " . $companyInfo['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header & Navigation -->
    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php">
                        
                        <h1>Mflip<span>Adventures</span></h1>
                        <p class="tagline">& Safaris</p>
                    </a>
                </div>
                
                <ul class="nav-menu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="tours.php">Tours</a></li>
                    <li><a href="about.php" class="active">About</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="booking.php" class="btn-book">Book Now</a></li>
                    <?php if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                        <li><a href="admin/index.php" class="btn-admin"><i class="fas fa-cog"></i> Admin</a></li>
                    <?php endif; ?>
                </ul>
                
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </div>
    </header>

    <!-- About Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="about-hero-content">
                <h1>Our Story</h1>
                <p>Bringing authentic Kenyan adventures to the world since <?php echo $companyInfo['founded']; ?></p>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <!-- About Content Section -->
    <section class="about-content">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <div class="section-header">
                        <h2>Welcome to <?php echo htmlspecialchars($companyInfo['name']); ?></h2>
                        <div class="decorative-line"></div>
                    </div>
                    
                    <p class="intro-text">
                        Based in the heart of <strong><?php echo htmlspecialchars($companyInfo['location']); ?></strong>, 
                        <?php echo htmlspecialchars($companyInfo['name']); ?> was founded in 
                        <strong><?php echo $companyInfo['founded']; ?></strong> with a simple mission: to share the breathtaking 
                        beauty of East Africa with the world while creating meaningful connections between travelers and local communities.
                    </p>
                    
                    <div class="about-highlights">
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="highlight-text">
                                <h3>Our Location</h3>
                                <p><strong><?php echo htmlspecialchars($companyInfo['location']); ?></strong> - The safari capital of the world, where urban sophistication meets wild adventure. Our central location allows us to access Kenya's most spectacular destinations with ease.</p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="highlight-text">
                                <h3>Year Founded</h3>
                                <p><strong><?php echo $companyInfo['founded']; ?></strong> - For nearly a decade, we've been crafting unforgettable safari experiences, building relationships with local communities, and perfecting the art of African adventure.</p>
                            </div>
                        </div>
                        
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div class="highlight-text">
                                <h3>Our Mission</h3>
                                <p><?php echo htmlspecialchars($companyInfo['mission']); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="story-section">
                        <h3>Our Journey</h3>
                        <p>What began as a small operation with one safari vehicle and two passionate guides has grown into one of Nairobi's most trusted tour companies. Our founder, "Mflip" , started this company after years of guiding experience across East Africa. He believed that tourists deserved more than just a checklist of animals - they deserved to understand and connect with the land, its people, and its conservation efforts.</p>
                        
                        <p>Today, we operate a fleet of custom-built safari vehicles, employ over 15 local experts, and have hosted travelers from more than 20 countries. Yet, we've never lost sight of our roots. Every safari we design carries the personal touch that only comes from deep local knowledge and genuine passion for our homeland.</p>
                    </div>
                </div>
                
                <div class="about-image">
                    <div class="image-frame">
                        <img src="assets/images/guides.jpeg" alt="<?php echo htmlspecialchars($companyInfo['name']); ?> Team in Nairobi">
                        <div class="image-caption">
                            <p>Our team of expert guides and staff in Nairobi</p>
                        </div>
                    </div>
                  <div class="stats-box">
    <?php foreach ($companyStats as $stat): ?>
        <div class="stat-item">
            <span class="stat-number">
                <?php echo htmlspecialchars($stat['value']); ?>
            </span>
            <span class="stat-label">
                <?php echo htmlspecialchars($stat['label']); ?>
            </span>
        </div>
    <?php endforeach; ?>
</div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nairobi Focus Section -->
    <section class="nairobi-section">
        <div class="container">
            <div class="nairobi-grid">
                <div class="nairobi-image">
                    <img src="assets/images/skyline-nairobi.jpg" alt="Nairobi Skyline">
                </div>
                <div class="nairobi-content">
                    <h2>Why <?php echo explode(',', $companyInfo['location'])[0]; ?>?</h2>
                    <p><?php echo explode(',', $companyInfo['location'])[0]; ?> is more than just our home base - it's the perfect gateway to East Africa's wonders. As the world's only capital city with a national park within its boundaries, <?php echo explode(',', $companyInfo['location'])[0]; ?> offers a unique blend of urban sophistication and wild adventure.</p>
                    
                    <div class="nairobi-features">
                        <div class="feature">
 <!--                           <img src="assets/assets/1674110151_39_wildlife-3233525_1280.jpg" alt="">-->
                            <h4>Nairobi National Park</h4>
                            <p>Just 7km from the city center, experience wildlife against a city skyline backdrop.</p>
                        </div>
                        <div class="feature">
                            <h4>Transport Hub</h4>
                            <p>Jomo Kenyatta International Airport connects us to all major safari destinations.</p>
                        </div>
                        <div class="feature">
                            <h4>Cultural Melting Pot</h4>
                            <p>Nairobi's diverse communities offer rich cultural experiences alongside wildlife adventures.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <h2>Meet Our Leadership</h2>
                <p>The passionate team behind your Kenyan adventure</p>
            </div>
            
            <div class="team-grid">
                <?php foreach($teamMembers as $member): ?>
                <div class="team-member">
                    <div class="member-image">
                        <img src="assets/images/about/<?php echo htmlspecialchars($member['image']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
                    </div>
                    <div class="member-info">
                        <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                        <p class="position"><?php echo htmlspecialchars($member['position']); ?></p>
                        <p class="bio"><?php echo htmlspecialchars($member['bio']); ?></p>
                        <div class="member-contact">
                            <?php foreach($member['qualifications'] as $qualification): ?>
                            <span><i class="fas fa-certificate"></i> <?php echo htmlspecialchars($qualification); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Core Values</h2>
                <p>The principles that guide every safari we create</p>
            </div>
            
            <div class="values-grid">
                <?php foreach($coreValues as $value): ?>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-<?php echo htmlspecialchars($value['icon']); ?>"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($value['title']); ?></h3>
                    <p><?php echo htmlspecialchars($value['description']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="about-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Experience Kenya with Us?</h2>
                <p>Join thousands of travelers who've discovered the magic of Africa through our authentic safaris</p>
                <div class="cta-buttons">
                    <a href="tours.php" class="btn-cta">Explore Our Tours</a>
                    <a href="contact.php" class="btn-cta-alt">Contact Our Team</a>
                </div>
            </div>
        </div>
    </section>
 

    <script src="assets/js/main.js"></script>
    <script src="assets/js/about.js"></script>
</body>
</html>