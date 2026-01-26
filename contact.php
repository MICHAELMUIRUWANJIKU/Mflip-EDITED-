<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | MflipAdventures & Safaris</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
    <!-- Header -->
    <?php include('header.php'); ?>

    <!-- Contact Hero -->
    <section class="contact-hero">
        <div class="container">
            <h1>Get In Touch</h1>
            <p>We're here to help plan your perfect Kenyan adventure</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2>Send us a Message</h2>
                    <p>Fill out the form below and we'll get back to you within 24 hours</p>
                    
                    <form id="contactForm" class="contact-form" action="process-contact.php" method="POST">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Enter your full name">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required placeholder="Enter your email">
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="" disabled selected>Select a subject</option>
                                <option value="booking">Booking Inquiry</option>
                                <option value="custom">Custom Safari Request</option>
                                <option value="general">General Information</option>
                                <option value="partnership">Partnership Opportunity</option>
                                <option value="feedback">Feedback</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your Message *</label>
                            <textarea id="message" name="message" rows="6" required placeholder="Tell us about your safari plans..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="captcha">
                                <label for="captcha">What is 5 + 3? *</label>
                                <input type="text" id="captcha" name="captcha" required placeholder="Enter the result">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                        
                        <div class="form-message" id="formMessage"></div>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div class="contact-info-container">
                    <h2>Contact Information</h2>
                    <p>Reach out to us through any of these channels</p>
                    
                    <div class="contact-info-grid">
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Our Office</h3>
                                <p>Nairobi Safari House</p>
                                <p>Karen Road, Nairobi, Kenya</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Call Us</h3>
                                <p>+254 700 123 456</p>
                                <p>+254 711 987 654</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Email Us</h3>
                                <p>info@mflipadventures.com</p>
                                <p>bookings@mflipadventures.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Business Hours</h3>
                                <p>Mon - Fri: 8:00 AM - 6:00 PM</p>
                                <p>Sat: 9:00 AM - 4:00 PM</p>
                                <p>Sun: 10:00 AM - 2:00 PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-contact">
                        <h3>Follow Our Adventures</h3>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-tripadvisor"></i></a>
                        </div>
                    </div>
                    
                    <div class="emergency-contact">
                        <h3><i class="fas fa-exclamation-triangle"></i> Emergency Contact</h3>
                        <p>For urgent safari-related emergencies during tours:</p>
                        <p class="emergency-number">+254 722 555 777</p>
                        <small>Available 24/7 for our touring clients</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <h2>Find Our Office in Nairobi</h2>
            <div id="map"></div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2>Frequently Asked Questions</h2>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What's the best time for a safari in Kenya?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>The best time is during the dry seasons: January to March and June to October. The Great Migration in Masai Mara peaks from July to October.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What should I pack for a Kenyan safari?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Neutral-colored clothing, comfortable walking shoes, hat, sunscreen, binoculars, camera, and light jacket for cool mornings/evenings.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do I need vaccinations for Kenya?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yellow fever vaccination is required. Malaria prophylaxis is recommended. Consult your doctor 4-6 weeks before travel.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What's your cancellation policy?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Full refund 60+ days before departure. 50% refund 30-59 days before. No refund within 30 days. Travel insurance is recommended.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/contact.js"></script>
</body>
</html>