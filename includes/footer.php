    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <h2>Mflip<span>Adventures</span></h2>
                        <p class="tagline">& Safaris</p>
                    </div>
                    <p>Providing unforgettable safari experiences in Nairobi and across Kenya since 2015.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-tripadvisor"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="tours.php">Tours</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="booking.php">Booking</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Contact Info</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> Nairobi, Kenya</li>
                        <li><i class="fas fa-phone"></i> +254 700 123 456</li>
                        <li><i class="fas fa-envelope"></i> info@mflipadventures.com</li>
                        <li><i class="fas fa-clock"></i> Mon - Sat: 8:00 AM - 6:00 PM</li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Newsletter</h3>
                    <p>Subscribe for safari tips and exclusive offers</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <span id="currentYear"></span> MflipAdventures & Safaris. All rights reserved.</p>
                <p><a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms & Conditions</a></p>
            </div>
        </div>
    </footer>

    <!-- All JavaScript files -->
    <script src="assets/js/main.js"></script>
    
    <!-- Page-specific JS -->
    <?php if (file_exists('assets/js/' . $current_page . '.js')): ?>
    <script src="assets/js/<?php echo $current_page; ?>.js"></script>
    <?php endif; ?>
    
    <!-- Page-specific additional JS -->
    <?php if (isset($additional_js)): ?>
    <?php foreach ($additional_js as $js): ?>
    <script src="<?php echo $js; ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>