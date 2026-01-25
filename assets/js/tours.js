// Tours Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const durationFilter = document.getElementById('duration-filter');
    const priceFilter = document.getElementById('price-filter');
    const typeFilter = document.getElementById('type-filter');
    const filterReset = document.querySelector('.filter-reset');
    const tourCards = document.querySelectorAll('.tour-card');
    const noToursMessage = document.querySelector('.no-tours-message');
    
    // Function to filter tours
    function filterTours() {
        const durationValue = durationFilter.value;
        const priceValue = priceFilter.value;
        const typeValue = typeFilter.value;
        
        let visibleTours = 0;
        
        tourCards.forEach(card => {
            const cardDuration = card.getAttribute('data-duration');
            const cardPrice = card.getAttribute('data-price');
            const cardType = card.getAttribute('data-type');
            
            const durationMatch = durationValue === 'all' || cardDuration === durationValue;
            const priceMatch = priceValue === 'all' || cardPrice === priceValue;
            const typeMatch = typeValue === 'all' || cardType === typeValue;
            
            if (durationMatch && priceMatch && typeMatch) {
                card.style.display = 'block';
                visibleTours++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no tours message
        if (visibleTours === 0) {
            noToursMessage.style.display = 'block';
        } else {
            noToursMessage.style.display = 'none';
        }
    }
    
    // Event listeners for filters
    durationFilter.addEventListener('change', filterTours);
    priceFilter.addEventListener('change', filterTours);
    typeFilter.addEventListener('change', filterTours);
    
    // Reset filters
    filterReset.addEventListener('click', function() {
        durationFilter.value = 'all';
        priceFilter.value = 'all';
        typeFilter.value = 'all';
        filterTours();
    });
    
    // Initialize filter
    filterTours();
    
    // Tour card hover effect enhancement
    tourCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });
});