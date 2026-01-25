// Contact Form Functionality
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');
    
    // Form submission
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simple validation
        const captcha = document.getElementById('captcha');
        if (captcha.value !== '8') {
            showMessage('Please answer the security question correctly (5 + 3 = 8)', 'error');
            return;
        }
        
        // Show success message (in real app, this would send to server)
        showMessage('Thank you! Your message has been sent. We\'ll respond within 24 hours.', 'success');
        
        // Reset form
        setTimeout(() => {
            contactForm.reset();
            formMessage.style.display = 'none';
        }, 5000);
    });
    
    function showMessage(text, type) {
        formMessage.textContent = text;
        formMessage.className = 'form-message ' + type;
        formMessage.style.display = 'block';
        
        // Scroll to message
        formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    // Initialize map
    if (document.getElementById('map')) {
        const map = L.map('map').setView([-1.2921, 36.8219], 13); // Nairobi coordinates
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Add marker
        L.marker([-1.2921, 36.8219])
            .addTo(map)
            .bindPopup('<b>MflipAdventures & Safaris</b><br>Nairobi Safari House, Karen Road')
            .openPopup();
    }
    
    // FAQ toggle functionality
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            // Close other open items
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current item
            item.classList.toggle('active');
        });
    });
});