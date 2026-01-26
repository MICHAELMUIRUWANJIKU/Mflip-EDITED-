<?php
session_start();
$page_title = 'Book Your Safari Adventure';
?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MflipAdventures & Safaris - Nairobi Tour Experts</title>
    <link rel="stylesheet" href="assets/css/booking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="icon" href="assets/images/mflip favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/images/mflip favicon.png" type="image/png">
    <link rel="icon" href="assets/images/mflip favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/images/mflip favicon.png" type="image/png">
  </head>
<!-- Booking Hero -->
<section class="booking-hero">
    <div class="container">
        <h1>Book Your Safari Adventure</h1>
        <p>Secure your spot for an unforgettable Kenyan experience</p>
    </div>
</section>

<!-- Booking Process -->
<section class="booking-process">
    <div class="container">
        <div class="process-steps">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Tour Selection</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Traveler Details</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>
    </div>
</section>

<!-- Step 1: Tour Selection -->
<section class="booking-step active" id="step1">
    <div class="container">
        <div class="step-header">
            <h2>Select Your Safari Tour</h2>
            <p>Choose from our curated selection of Kenyan adventures</p>
        </div>
        
        <div class="tour-selection-grid">
            <?php
            // Fetch tours from database (simulated)
            $tours = [
                ['id' => 1, 'title' => 'Masai Mara Great Migration', 'price' => 850, 'duration' => '3 Days', 'image' => 'assets/images/Masai-Mara-Wildebeest-Migration.jpg'],
                ['id' => 2, 'title' => 'Nairobi National Park Day Trip', 'price' => 120, 'duration' => '1 Day', 'image' => 'nairobi-park.jpg'],
                ['id' => 3, 'title' => 'Amboseli Elephant Safari', 'price' => 420, 'duration' => '2 Days', 'image' => 'amboseli.jpg'],
                ['id' => 4, 'title' => 'Samburu Cultural Experience', 'price' => 750, 'duration' => '4 Days', 'image' => 'samburu.jpg'],
            ];
            
            foreach ($tours as $tour) {
                echo '
                <div class="tour-option" data-tour-id="' . $tour['id'] . '" data-tour-price="' . $tour['price'] . '">
                    <div class="tour-option-image" style="background-image: url(\'assets/images/tours/' . $tour['image'] . '\');">
                        <span class="tour-duration">' . $tour['duration'] . '</span>
                    </div>
                    <div class="tour-option-content">
                        <h3>' . $tour['title'] . '</h3>
                        <div class="tour-price">$' . number_format($tour['price']) . '</div>
                        <button class="btn-select-tour">Select This Tour</button>
                    </div>
                </div>';
            }
            ?>
        </div>
        
        <div class="step-navigation">
            <button class="btn-next" data-next="2">Next: Traveler Details</button>
        </div>
    </div>
</section>

<!-- Step 2: Traveler Details -->
<section class="booking-step" id="step2">
    <div class="container">
        <div class="step-header">
            <h2>Traveler Information</h2>
            <p>Please provide details for all travelers</p>
        </div>
        
        <form id="travelerForm" class="booking-form">
            <!-- Selected Tour Display -->
            <div class="selected-tour-summary">
                <h3>Selected Tour: <span id="selectedTourTitle">Masai Mara Great Migration</span></h3>
                <p>Price: $<span id="selectedTourPrice">850</span> per person</p>
            </div>
            
            <div class="form-section">
                <h3>Primary Traveler</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullName">Full Name *</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality *</label>
                        <input type="text" id="nationality" name="nationality" required>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Trip Details</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="participants">Number of Travelers *</label>
                        <select id="participants" name="participants" required>
                            <option value="">Select</option>
                            <?php for($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> <?php echo $i == 1 ? 'person' : 'people'; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="preferredDate">Preferred Start Date *</label>
                        <input type="date" id="preferredDate" name="preferredDate" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="accommodation">Accommodation Preference</label>
                    <select id="accommodation" name="accommodation">
                        <option value="camping">Camping (Budget)</option>
                        <option value="lodge">Lodge (Standard)</option>
                        <option value="luxury">Luxury Tented Camp</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Additional Information</h3>
                <div class="form-group">
                    <label for="specialRequests">Special Requests</label>
                    <textarea id="specialRequests" name="specialRequests" rows="4" placeholder="Dietary requirements, mobility needs, special occasions, etc."></textarea>
                </div>
            </div>
            
            <div class="price-summary">
                <div class="summary-row">
                    <span>Tour Price x <span id="summaryParticipants">1</span> person(s)</span>
                    <span>$<span id="summaryBasePrice">850</span></span>
                </div>
                <div class="summary-row">
                    <span>Accommodation Upgrade</span>
                    <span>$<span id="summaryUpgrade">0</span></span>
                </div>
                <div class="summary-row total">
                    <span>Total Amount</span>
                    <span>$<span id="summaryTotal">850</span></span>
                </div>
            </div>
        </form>
        
        <div class="step-navigation">
            <button class="btn-prev" data-prev="1">Back: Tour Selection</button>
            <button class="btn-next" data-next="3">Next: Confirmation</button>
        </div>
    </div>
</section>

<!-- Step 3: Confirmation -->
<section class="booking-step" id="step3">
    <div class="container">
        <div class="step-header">
            <h2>Confirm Your Booking</h2>
            <p>Review your details and complete the booking</p>
        </div>
        
        <div class="confirmation-summary">
            <div class="summary-card">
                <h3>Tour Details</h3>
                <div class="summary-details">
                    <div class="detail-item">
                        <span class="detail-label">Tour:</span>
                        <span class="detail-value" id="confirmTour">Masai Mara Great Migration</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date:</span>
                        <span class="detail-value" id="confirmDate">Not selected</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Travelers:</span>
                        <span class="detail-value" id="confirmTravelers">1</span>
                    </div>
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Traveler Information</h3>
                <div class="summary-details">
                    <div class="detail-item">
                        <span class="detail-label">Name:</span>
                        <span class="detail-value" id="confirmName">Not provided</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value" id="confirmEmail">Not provided</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value" id="confirmPhone">Not provided</span>
                    </div>
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Payment Summary</h3>
                <div class="summary-details">
                    <div class="detail-item">
                        <span class="detail-label">Tour Cost:</span>
                        <span class="detail-value">$<span id="confirmCost">850</span></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Total Amount:</span>
                        <span class="detail-value total-amount">$<span id="confirmTotal">850</span></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="payment-options">
            <h3>Select Payment Method</h3>
            <div class="payment-methods">
                <div class="payment-method">
                    <input type="radio" id="paypal" name="paymentMethod" value="paypal">
                    <label for="paypal">
                        <i class="fab fa-paypal"></i>
                        <span>PayPal</span>
                    </label>
                </div>
                <div class="payment-method">
                    <input type="radio" id="mpesa" name="paymentMethod" value="mpesa">
                    <label for="mpesa">
                        <i class="fas fa-mobile-alt"></i>
                        <span>M-Pesa</span>
                    </label>
                </div>
                <div class="payment-method">
                    <input type="radio" id="bank" name="paymentMethod" value="bank">
                    <label for="bank">
                        <i class="fas fa-university"></i>
                        <span>Bank Transfer</span>
                    </label>
                </div>
                <div class="payment-method">
                    <input type="radio" id="cash" name="paymentMethod" value="cash">
                    <label for="cash">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Cash on Arrival</span>
                    </label>
                </div>
            </div>
            
            <div class="terms-agreement">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="terms.php">Terms & Conditions</a> and <a href="privacy.php">Privacy Policy</a></label>
            </div>
        </div>
        
        <div class="step-navigation">
            <button class="btn-prev" data-prev="2">Back: Traveler Details</button>
            <button class="btn-submit-booking" id="submitBooking">Complete Booking</button>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="success-modal" id="successModal">
    <div class="modal-content">
        <div class="modal-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3>Booking Confirmed!</h3>
        <p>Your safari adventure has been successfully booked.</p>
        <p class="booking-ref">Reference: <strong id="bookingReference">MF2024-00123</strong></p>
        <div class="modal-actions">
            <button class="btn-print" id="printBooking">Print Confirmation</button>
            <a href="index.php" class="btn-home">Return Home</a>
        </div>
    </div>
</div>
    <script src="assets/js/booking.js"></script>

<?php include('footer.php'); ?>