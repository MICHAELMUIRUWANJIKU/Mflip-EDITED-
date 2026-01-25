// Gallery Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const viewButtons = document.querySelectorAll('.view-btn');
    const loadMoreBtn = document.getElementById('loadMore');
    const lightboxModal = document.getElementById('lightboxModal');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxTitle = document.getElementById('lightboxTitle');
    const lightboxCategory = document.getElementById('lightboxCategory');
    const closeLightbox = document.getElementById('closeLightbox');
    const prevBtn = document.querySelector('.lightbox-nav.prev');
    const nextBtn = document.querySelector('.lightbox-nav.next');
    
    let currentImageIndex = 0;
    const allImages = Array.from(galleryItems);
    let filteredImages = [...allImages];
    
    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // Filter items
            galleryItems.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
            
            // Update filtered images array
            filteredImages = Array.from(galleryItems).filter(item => {
                return filterValue === 'all' || item.getAttribute('data-category') === filterValue;
            });
        });
    });
    
    // Lightbox functionality
    viewButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const item = this.closest('.gallery-item');
            const imgSrc = item.querySelector('img').src;
            const title = item.querySelector('.gallery-info h3').textContent;
            const category = item.querySelector('.gallery-info p').textContent;
            
            currentImageIndex = filteredImages.indexOf(item);
            
            openLightbox(imgSrc, title, category);
        });
    });
    
    function openLightbox(src, title, category) {
        lightboxImage.src = src;
        lightboxTitle.textContent = title;
        lightboxCategory.textContent = category;
        lightboxModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Add fade-in effect
        lightboxModal.style.opacity = '0';
        setTimeout(() => {
            lightboxModal.style.transition = 'opacity 0.3s ease';
            lightboxModal.style.opacity = '1';
        }, 10);
    }
    
    function closeLightboxFunc() {
        lightboxModal.style.opacity = '0';
        setTimeout(() => {
            lightboxModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }, 300);
    }
    
    function navigateLightbox(direction) {
        currentImageIndex += direction;
        
        if (currentImageIndex < 0) {
            currentImageIndex = filteredImages.length - 1;
        } else if (currentImageIndex >= filteredImages.length) {
            currentImageIndex = 0;
        }
        
        const nextItem = filteredImages[currentImageIndex];
        const imgSrc = nextItem.querySelector('img').src;
        const title = nextItem.querySelector('.gallery-info h3').textContent;
        const category = nextItem.querySelector('.gallery-info p').textContent;
        
        // Add fade transition
        lightboxImage.style.transition = 'opacity 0.3s ease';
        lightboxImage.style.opacity = '0';
        
        setTimeout(() => {
            lightboxImage.src = imgSrc;
            lightboxTitle.textContent = title;
            lightboxCategory.textContent = category;
            lightboxImage.style.opacity = '1';
        }, 300);
    }
    
    // Event listeners for lightbox
    closeLightbox.addEventListener('click', closeLightboxFunc);
    
    lightboxModal.addEventListener('click', function(e) {
        if (e.target === lightboxModal) {
            closeLightboxFunc();
        }
    });
    
    prevBtn.addEventListener('click', () => navigateLightbox(-1));
    nextBtn.addEventListener('click', () => navigateLightbox(1));
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (lightboxModal.style.display === 'flex') {
            if (e.key === 'Escape') {
                closeLightboxFunc();
            } else if (e.key === 'ArrowLeft') {
                navigateLightbox(-1);
            } else if (e.key === 'ArrowRight') {
                navigateLightbox(1);
            }
        }
    });
    
    // Load more functionality
    let currentItems = 15;
    const totalSimulatedItems = 30;
    
    loadMoreBtn.addEventListener('click', function() {
        const button = this;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        button.disabled = true;
        
        // Simulate API call delay
        setTimeout(() => {
            // In a real app, you would fetch from server
            // For demo, we'll simulate adding more items
            currentItems += 5;
            
            if (currentItems >= totalSimulatedItems) {
                button.style.display = 'none';
                
                // Show completion message
                const completionMsg = document.createElement('p');
                completionMsg.className = 'load-complete';
                completionMsg.innerHTML = '<i class="fas fa-check-circle"></i> All photos loaded';
                completionMsg.style.textAlign = 'center';
                completionMsg.style.color = 'var(--primary-green)';
                completionMsg.style.marginTop = '20px';
                completionMsg.style.fontWeight = '600';
                
                button.parentNode.appendChild(completionMsg);
            }
            
            button.innerHTML = '<i class="fas fa-plus"></i> Load More Photos';
            button.disabled = false;
            
            // Simulate adding new items to DOM
            simulateNewGalleryItems();
            
        }, 1500);
    });
    
    function simulateNewGalleryItems() {
        // In a real app, this would fetch from server and append to gallery
        // For now, we'll just update the count
        const countElement = document.createElement('div');
        countElement.style.textAlign = 'center';
        countElement.style.marginTop = '20px';
        countElement.style.color = 'var(--gray-medium)';
        countElement.innerHTML = `<i class="fas fa-info-circle"></i> Showing ${Math.min(currentItems, totalSimulatedItems)} of ${totalSimulatedItems} photos`;
        
        // Remove previous count if exists
        const prevCount = document.querySelector('.item-count');
        if (prevCount) prevCount.remove();
        
        countElement.className = 'item-count';
        loadMoreBtn.parentNode.insertBefore(countElement, loadMoreBtn.nextSibling);
    }
    
    // Video play functionality
    const playButtons = document.querySelectorAll('.play-btn');
    const videoCards = document.querySelectorAll('.video-card');
    
    playButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const videoCard = videoCards[index];
            const title = videoCard.querySelector('.video-info h3').textContent;
            
            // Create video modal
            const videoModal = document.createElement('div');
            videoModal.className = 'video-modal';
            videoModal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                z-index: 2001;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                padding: 20px;
            `;
            
            videoModal.innerHTML = `
                <button class="video-close" style="
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    background: none;
                    border: none;
                    color: white;
                    font-size: 2rem;
                    cursor: pointer;
                ">
                    <i class="fas fa-times"></i>
                </button>
                <div style="max-width: 800px; width: 100%;">
                    <div style="
                        background: #222;
                        border-radius: 10px 10px 0 0;
                        padding: 20px;
                        color: white;
                    ">
                        <h3 style="margin: 0; color: white;">${title}</h3>
                    </div>
                    <div style="
                        background: #000;
                        aspect-ratio: 16/9;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 0 0 10px 10px;
                        overflow: hidden;
                    ">
                        <div style="text-align: center; color: white;">
                            <i class="fas fa-play-circle" style="font-size: 4rem; color: var(--primary-green);"></i>
                            <p style="margin-top: 20px;">Video player would appear here</p>
                            <p style="font-size: 0.9rem; opacity: 0.7;">(In a real implementation, this would embed a YouTube/Vimeo player)</p>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(videoModal);
            document.body.style.overflow = 'hidden';
            
            // Close video modal
            const closeBtn = videoModal.querySelector('.video-close');
            closeBtn.addEventListener('click', function() {
                document.body.removeChild(videoModal);
                document.body.style.overflow = 'auto';
            });
            
            // Close on background click
            videoModal.addEventListener('click', function(e) {
                if (e.target === videoModal) {
                    document.body.removeChild(videoModal);
                    document.body.style.overflow = 'auto';
                }
            });
            
            // Close on Escape key
            document.addEventListener('keydown', function closeOnEscape(e) {
                if (e.key === 'Escape' && document.body.contains(videoModal)) {
                    document.body.removeChild(videoModal);
                    document.body.style.overflow = 'auto';
                    document.removeEventListener('keydown', closeOnEscape);
                }
            });
        });
    });
    
    // Initialize with animation
    setTimeout(() => {
        galleryItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 50); // Stagger effect
        });
    }, 100);
    
    // Smooth scroll for filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const gallerySection = document.querySelector('.gallery-grid-section');
            gallerySection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });
});