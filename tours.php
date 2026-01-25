<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Safari Tours | MflipAdventures & Safaris</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/tours.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include('includes/header.php'); ?>

    <!-- Tours Hero -->
    <section class="tours-hero">
        <div class="container">
            <h1>Explore Our Safari Adventures</h1>
            <p>From Nairobi day trips to multi-day expeditions across Kenya's most iconic parks</p>
        </div>
    </section>

    <!-- Tours Filter -->
    <section class="tours-filter">
        <div class="container">
            <div class="filter-container">
                <div class="filter-group">
                    <label for="duration-filter"><i class="fas fa-clock"></i> Duration</label>
                    <select id="duration-filter" class="filter-select">
                        <option value="all">All Durations</option>
                        <option value="1">1 Day</option>
                        <option value="2-3">2-3 Days</option>
                        <option value="4-7">4-7 Days</option>
                        <option value="7+">7+ Days</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="price-filter"><i class="fas fa-dollar-sign"></i> Price Range</label>
                    <select id="price-filter" class="filter-select">
                        <option value="all">All Prices</option>
                        <option value="budget">Under $300</option>
                        <option value="mid">$300 - $700</option>
                        <option value="premium">$700+</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="type-filter"><i class="fas fa-map-marked-alt"></i> Tour Type</label>
                    <select id="type-filter" class="filter-select">
                        <option value="all">All Types</option>
                        <option value="wildlife">Wildlife Safari</option>
                        <option value="cultural">Cultural Experience</option>
                        <option value="adventure">Adventure</option>
                        <option value="luxury">Luxury Safari</option>
                    </select>
                </div>
                
                <button class="filter-reset">Reset Filters</button>
            </div>
        </div>
    </section>

    <!-- Tours Grid -->
    <section class="all-tours">
        <div class="container">
            <div class="tours-grid" id="tours-container">
                <!-- Tours will be loaded here dynamically -->
                <?php
                // Sample PHP data - in real app, fetch from database
                $tours = [
                    [
                        'id' => 1,
                        'title' => 'Masai Mara Great Migration',
                        'description' => 'Witness the spectacular wildebeest migration in the Masai Mara, Africa\'s greatest wildlife spectacle.',
                        'duration' => '3 Days',
                        'price' => 850,
                        'type' => 'wildlife',
                        'difficulty' => 'Moderate',
                        'rating' => 4.9,
                        'image' => 'masai-mara.jpg',
                        'featured' => true
                    ],
                    [
                        'id' => 2,
                        'title' => 'Nairobi National Park Day Trip',
                        'description' => 'Experience wildlife against a city skyline in the world\'s only wildlife capital.',
                        'duration' => '1 Day',
                        'price' => 120,
                        'type' => 'wildlife',
                        'difficulty' => 'Easy',
                        'rating' => 4.7,
                        'image' => 'nairobi-park.jpg',
                        'featured' => false
                    ],
                    [
                        'id' => 3,
                        'title' => 'Amboseli Elephant Safari',
                        'description' => 'Marvel at elephants with the majestic Mount Kilimanjaro as your backdrop.',
                        'duration' => '2 Days',
                        'price' => 420,
                        'type' => 'wildlife',
                        'difficulty' => 'Easy',
                        'rating' => 4.8,
                        'image' => 'amboseli.jpg',
                        'featured' => false
                    ],
                    [
                        'id' => 4,
                        'title' => 'Samburu Cultural Experience',
                        'description' => 'Immerse yourself in the unique culture of the Samburu people and see rare wildlife.',
                        'duration' => '4 Days',
                        'price' => 750,
                        'type' => 'cultural',
                        'difficulty' => 'Moderate',
                        'rating' => 4.6,
                        'image' => 'samburu.jpg',
                        'featured' => false
                    ],
                    [
                        'id' => 5,
                        'title' => 'Tsavo West Adventure Safari',
                        'description' => 'Explore Kenya\'s largest national park with diverse landscapes and wildlife.',
                        'duration' => '5 Days',
                        'price' => 1100,
                        'type' => 'adventure',
                        'difficulty' => 'Challenging',
                        'rating' => 4.9,
                        'image' => 'tsavo.jpg',
                        'featured' => true
                    ],
                    [
                        'id' => 6,
                        'title' => 'Lake Nakuru Flamingo Tour',
                        'description' => 'See millions of flamingos at Lake Nakuru, a bird watcher\'s paradise.',
                        'duration' => '2 Days',
                        'price' => 380,
                        'type' => 'wildlife',
                        'difficulty' => 'Easy',
                        'rating' => 4.5,
                        'image' => 'nakuru.jpg',
                        'featured' => false
                    ],
                    [
                        'id' => 7,
                        'title' => 'Luxury Mara Conservancies',
                        'description' => 'Exclusive luxury safari in private conservancies with premium accommodations.',
                        'duration' => '7 Days',
                        'price' => 2800,
                        'type' => 'luxury',
                        'difficulty' => 'Easy',
                        'rating' => 5.0,
                        'image' => 'luxury-mara.jpg',
                        'featured' => true
                    ],
                    [
                        'id' => 8,
                        'title' => 'Hell\'s Gate Cycling Adventure',
                        'description' => 'Cycling and hiking adventure in Hell\'s Gate National Park, no predators.',
                        'duration' => '1 Day',
                        'price' => 95,
                        'type' => 'adventure',
                        'difficulty' => 'Moderate',
                        'rating' => 4.4,
                        'image' => 'hells-gate.jpg',
                        'featured' => false
                    ]
                ];
                
                foreach ($tours as $tour) {
                    echo '
                    <div class="tour-card" data-duration="' . (strpos($tour['duration'], '1') !== false ? '1' : (intval($tour['duration']) > 7 ? '7+' : '2-3')) . '" 
                         data-price="' . ($tour['price'] < 300 ? 'budget' : ($tour['price'] <= 700 ? 'mid' : 'premium')) . '" 
                         data-type="' . $tour['type'] . '">
                        ' . ($tour['featured'] ? '<span class="featured-badge">Featured</span>' : '') . '
                        <div class="tour-image" style="background-image: url(\'assets/images/tours/' . $tour['image'] . '\');">
                            <span class="tour-duration">' . $tour['duration'] . '</span>
                        </div>
                        <div class="tour-content">
                            <div class="tour-header">
                                <h3>' . $tour['title'] . '</h3>
                                <div class="tour-rating">
                                    <i class="fas fa-star"></i>
                                    <span>' . $tour['rating'] . '</span>
                                </div>
                            </div>
                            <p>' . $tour['description'] . '</p>
                            <div class="tour-meta">
                                <span class="tour-type"><i class="fas fa-tag"></i> ' . ucfirst($tour['type']) . '</span>
                                <span class="tour-difficulty"><i class="fas fa-hiking"></i> ' . $tour['difficulty'] . '</span>
                            </div>
                            <div class="tour-info">
                                <span class="price">$' . number_format($tour['price']) . '</span>
                                <div class="tour-actions">
                                    <a href="tour-details.php?id=' . $tour['id'] . '" class="btn-tour">View Details</a>
                                    <a href="booking.php?tour_id=' . $tour['id'] . '" class="btn-book-now">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
            
            <div class="no-tours-message" style="display: none;">
                <i class="fas fa-search"></i>
                <h3>No tours match your filters</h3>
                <p>Try adjusting your search criteria</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="tour-testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What Our Travelers Say</h2>
                <p>Real experiences from our safari adventurers</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>"The Masai Mara tour exceeded all expectations. Our guide James was incredibly knowledgeable and we saw the Big Five!"</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/testimonials/client1.jpg" alt="Sarah Johnson">
                        <div>
                            <h4>Sarah Johnson</h4>
                            <span>USA · Masai Mara Tour</span>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>"Amazing cultural experience with the Samburu people. The team at MflipAdventures made us feel like family."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="assets/images/testimonials/client2.jpg" alt="David Chen">
                        <div>
                            <h4>David Chen</h4>
                            <span>China · Samburu Cultural Tour</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/tours.js"></script>
</body>
</html>