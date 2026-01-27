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
    <?php include('header.php'); ?>

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
                    <label for="price-filter"></i> Price Range</label>
                    <select id="price-filter" class="filter-select">
                        <option value="all">All Prices</option>
                        <option value="budget">Under Ksh3000</option>
                        <option value="mid">3000 - KSH7000</option>
                        <option value="premium">Above KSH7000</option>
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
            <?php
            // Sample PHP data - in real app, fetch from database
            $tours = [
                [
                    'id' => 1,
                    'title' => 'TWENDE SUSWA',
                    'description' => 'This is not just a trip — it\'s an EXPERIENCE. Let\'s create memories under the stars.',
                    'duration' => '1 Day',
                    'price' => 1550,
                    'type' => 'adventure',
                    'difficulty' => 'Easy',
                    'rating' => 4.9,
                    'image' => 'suswa-trip.jpeg',
                    'featured' => true
                ],
                [
                    'id' => 2,
                    'title' => 'Samburu Overland Truck Party at Buffalo Spring National Reserve',
                    'description' => 'Experience the wild like never before at Buffalo Springs National Reserve in Isiolo, Kenya! Spot majestic elephants, lions, and giraffes on thrilling game drives, take in breathtaking views from a hot air balloon, and connect with the vibrant Samburu culture. Adventure, wildlife, and unforgettable memories await—come explore Kenya\'s hidden gem!',
                    'duration' => '1 Day',
                    'price' => 9000,
                    'type' => 'wildlife',
                    'difficulty' => 'Easy',
                    'rating' => 4.7,
                    'image' => 'buffalo-spring-resort.jpg',
                    'featured' => true
                ],
                [
                    'id' => 3,
                    'title' => 'SGR ride to Mombasa',
                    'description' => 'Escape to the coastal paradise of Mombasa, Kenya! Relax on golden beaches, explore historic forts, 
                    and dive into vibrant marine life in the 
                    Indian Ocean using SGR.',
                    'duration' => '3 Days',
                    'price' => 9500,
                    'type' => 'luxury',
                    'difficulty' => 'Moderate',
                    'rating' => 4.8,
                    'image' => 'KENYAN_COAST.jpg',
                    'featured' => true
                ],
                [
                    'id' => 4,
                    'title' => 'KANUNGA & THURASHA WATERFALLS ',
                    'description' => 'Join us for an exhilarating hike at the Kanunga & Thurusha Waterfall Chase!
                     Experience the breathtaking beauty of Muranga county known for its lush rolling hills, vibrant tea farms, and majestic rivers. On April 20, 2025, we will embark on a scenic adventure starting at the stunning Ndakaini Dam, where we will trek through picturesque trails leading to the enchanting Kanunga and Thurusha waterfalls.',
                    'duration' => '2 Days',
                    'price' => 1800,
                    'type' => 'adventure',
                    'difficulty' => 'Moderate',
                    'rating' => 4.6,
                    'image' => 'nature.jpeg',
                    'featured' => false
                ],
                [
                    'id' => 5,
                    'title' => 'Tsavo West Adventure Safari',
                    'description' => 'Explore Kenya\'s largest national park with diverse landscapes and wildlife.Book Your Space Now',
                    'duration' => '3 Days',
                    'price' =>9000,
                    'type' => 'Wildlife',
                    'difficulty' => 'Challenging',
                    'rating' => 4.9,
                    'image' => 'samburu national park.jpg',
                    'featured' => false
                ],
                [
                    'id' => 6,
                    'title' => 'Nairobi National park Game Drive',
                    'description' => 'Experience a real African safari just minutes from the city skyline. Visit Nairobi National Park and witness breathtaking wildlife in its natural habitat.',
                    'duration' => '1 Day',
                    'price' => 4000,
                    'type' => 'wildlife',
                    'difficulty' => 'Easy',
                    'rating' => 4.5,
                    'image' => 'game drive.jpeg',
                    'featured' => false
                ],
                [
                    'id' => 7,
                    'title' => 'An adventure to Olkaria Geothermal Spa KenGen',
                    'description' => 'Discover pure relaxation at Olkaria Geothermal Spa – KenGen
Soak in naturally heated mineral waters, enjoy stunning views, and unwind in Kenya’s hidden geothermal gem. 
A perfect escape for mind, body, and soul.',
                    'duration' => '3 Days',
                    'price' => 7800,
                    'type' => 'luxury',
                    'difficulty' => 'Easy',
                    'rating' => 5.0,
                    'image' => 'kengen-trip.jpeg',
                    'featured' => false
                ],
                [
                    'id' => 8,
                    'title' => 'Leleshwa Gateway',
                    'description' => 'Escape to comfort, nature, and great food at Leleshwa Garden Resort. Visit today and unwind in a serene garden setting.',
                    'duration' => '1 Day',
                    'price' => 9500,
                    'type' => 'adventure',
                    'difficulty' => 'Moderate',
                    'rating' => 4.4,
                    'image' => 'LELESHWA GETAWAY-116.jpg',
                    'featured' => false
                ]
            ];
            
            foreach ($tours as $tour) {
                // Determine duration category
                $durationCategory = 'all';
                if (strpos($tour['duration'], '1') !== false) {
                    $durationCategory = '1';
                } elseif (intval($tour['duration']) >= 2 && intval($tour['duration']) <= 3) {
                    $durationCategory = '2-3';
                } elseif (intval($tour['duration']) >= 4 && intval($tour['duration']) <= 7) {
                    $durationCategory = '4-7';
                } elseif (intval($tour['duration']) > 7) {
                    $durationCategory = '7+';
                }
                
                // Determine price category
                $priceCategory = 'all';
                if ($tour['price'] < 3000) {
                    $priceCategory = 'budget';
                } elseif ($tour['price'] <= 7000) {
                    $priceCategory = 'mid';
                } else {
                    $priceCategory = 'premium';
                }
                
                // Format price
                $formattedPrice = 'KSH ' . number_format($tour['price'], 0);
                
                // Create image path with fallback
                $imagePath = 'assets/images/' . $tour['image'];
                $imageAlt = htmlspecialchars($tour['title']);
                
                echo '
                <div class="tour-card" data-duration="' . $durationCategory . '" 
                     data-price="' . $priceCategory . '" 
                     data-type="' . strtolower($tour['type']) . '">
                    ' . ($tour['featured'] ? '<span class="featured-badge">Featured</span>' : '') . '
                    <div class="tour-image-container">
                      <img src="' . $imagePath . '" 
     alt="' . $imageAlt . '" 
     class="tour-image">
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
                            <span class="price">' . $formattedPrice . '</span>
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
    <?php include('footer.php'); ?>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/tours.js"></script>
</body>
</html>