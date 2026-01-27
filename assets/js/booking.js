// Booking System Functionality
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const steps = document.querySelectorAll('.booking-step');
    const processSteps = document.querySelectorAll('.process-steps .step');
    const tourOptions = document.querySelectorAll('.tour-option');
    const btnNext = document.querySelectorAll('.btn-next');
    const btnPrev = document.querySelectorAll('.btn-prev');
    const btnSubmit = document.getElementById('submitBooking');
    const successModal = document.getElementById('successModal');
    const printBtn = document.getElementById('printBooking');
    
    // Booking Data Object
    let bookingData = {
        tourId: null,
        tourTitle: 'Masai Mara Great Migration',
        tourPrice: 850,
        fullName: '',
        email: '',
        phone: '',
        nationality: '',
        participants: 1,
        preferredDate: '',
        accommodation: 'camping',
        specialRequests: '',
        paymentMethod: '',
        totalAmount: 850
    };
    
    // Initialize
    updatePriceSummary();
    setMinDate();
    
    // Set minimum date to today
    function setMinDate() {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const formattedDate = tomorrow.toISOString().split('T')[0];
        document.getElementById('preferredDate').min = formattedDate;
    }
    
    // Tour Selection
    tourOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selection from all
            tourOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selection to clicked
            this.classList.add('selected');
            
            // Update booking data
            bookingData.tourId = this.getAttribute('data-tour-id');
            bookingData.tourTitle = this.querySelector('h3').textContent;
            bookingData.tourPrice = parseFloat(this.getAttribute('data-tour-price'));
            
            // Update step 2 display
            updateSelectedTourDisplay();
            updatePriceSummary();
            updateConfirmationSummary();
        });
    });
    
    function updateSelectedTourDisplay() {
        document.getElementById('selectedTourTitle').textContent = bookingData.tourTitle;
        document.getElementById('selectedTourPrice').textContent = bookingData.tourPrice.toFixed(0);
    }
    
    // Step Navigation
    btnNext.forEach(button => {
        button.addEventListener('click', function() {
            const nextStep = this.getAttribute('data-next');
            const currentStep = getCurrentStep();
            
            // Validate current step before proceeding
            if (!validateStep(currentStep)) {
                return;
            }
            
            // Save step data
            saveStepData(currentStep);
            
            // Navigate to next step
            navigateToStep(nextStep);
        });
    });
    
    btnPrev.forEach(button => {
        button.addEventListener('click', function() {
            const prevStep = this.getAttribute('data-prev');
            navigateToStep(prevStep);
        });
    });
    
    function getCurrentStep() {
        const activeStep = document.querySelector('.booking-step.active');
        return parseInt(activeStep.id.replace('step', ''));
    }
    
    function navigateToStep(stepNumber) {
        // Hide all steps
        steps.forEach(step => step.classList.remove('active'));
        processSteps.forEach(step => step.classList.remove('active'));
        
        // Show target step
        document.getElementById(`step${stepNumber}`).classList.add('active');
        document.querySelector(`.step[data-step="${stepNumber}"]`).classList.add('active');
        
        // Scroll to top of step
        document.getElementById(`step${stepNumber}`).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
    
    // Step Validation
    function validateStep(stepNumber) {
        switch(stepNumber) {
            case 1:
                if (!bookingData.tourId) {
                    alert('Please select a tour to continue');
                    return false;
                }
                return true;
                
            case 2:
                const form = document.getElementById('travelerForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return false;
                }
                return true;
                
            case 3:
                const paymentSelected = document.querySelector('input[name="paymentMethod"]:checked');
                const termsAccepted = document.getElementById('terms').checked;
                
                if (!paymentSelected) {
                    alert('Please select a payment method');
                    return false;
                }
                
                if (!termsAccepted) {
                    alert('Please agree to the terms and conditions');
                    return false;
                }
                
                return true;
                
            default:
                return true;
        }
    }
    
    // Save Step Data
    function saveStepData(stepNumber) {
        switch(stepNumber) {
            case 2:
                bookingData.fullName = document.getElementById('fullName').value;
                bookingData.email = document.getElementById('email').value;
                bookingData.phone = document.getElementById('phone').value;
                bookingData.nationality = document.getElementById('nationality').value;
                bookingData.participants = parseInt(document.getElementById('participants').value);
                bookingData.preferredDate = document.getElementById('preferredDate').value;
                bookingData.accommodation = document.getElementById('accommodation').value;
                bookingData.specialRequests = document.getElementById('specialRequests').value;
                
                // Update confirmation display
                updateConfirmationSummary();
                break;
                
            case 3:
                const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
                if (paymentMethod) {
                    bookingData.paymentMethod = paymentMethod.value;
                }
                break;
        }
    }
    
    // Price Calculation
    function calculateTotal() {
        const upgradePrices = {
            'camping': 0,
            'lodge': 50,
            'luxury': 150
        };
        
        const basePrice = bookingData.tourPrice * bookingData.participants;
        const upgradePrice = upgradePrices[bookingData.accommodation] * bookingData.participants;
        
        return basePrice + upgradePrice;
    }
    
    // Update Price Summary
    function updatePriceSummary() {
        const total = calculateTotal();
        
        // Update step 2 summary
        document.getElementById('summaryParticipants').textContent = bookingData.participants;
        document.getElementById('summaryBasePrice').textContent = (bookingData.tourPrice * bookingData.participants).toFixed(0);
        
        const upgradePrices