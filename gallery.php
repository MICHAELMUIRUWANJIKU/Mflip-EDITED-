<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery | MflipAdventures & Safaris</title>
      <link rel="icon" href="assets/images/mflip favicon.png" type="image/png">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/gallery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include('header.php'); ?>


    <!-- Gallery Hero -->
         <section class="gallery-hero">
      <div class="hero-slider">
            <div class="slide active" style="background-image: url('assets/images/slides/zip lining.jpeg');"></div>
            <div class="slide" style="background-image: url('assets/images/slides/sironka trip.JPG');"></div>
            <div class="slide" style="background-image: url('assets/images/slides/mudfun.jpeg');"></div>
            <div class="slide" style="background-image: url('assets/images/slides/park gate.jpeg');"></div>
            <div class="slide" style="background-image: url('assets/images/slides/diani.jpg');"></div>
        </div>
        <div class="container">
            <h1>Safari Moments Gallery</h1>
            <p>Capturing the magic of Kenya's wildlife and landscapes</p>
        </div>
    </section>

    <!-- Gallery Filter -->
    <section class="gallery-filter">
        <div class="container">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All Photos</button>
                <button class="filter-btn" data-filter="wildlife">Wildlife</button>
                <button class="filter-btn" data-filter="landscape">Landscapes</button>
                <button class="filter-btn" data-filter="cultural">Cultural</button>
                <button class="filter-btn" data-filter="safari-life">Safari Life</button>
                <button class="filter-btn" data-filter="sunset">Sunsets</button>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="gallery-grid-section">
        <div class="container">
            <div class="masonry-grid" id="gallery-container">
                <!-- Gallery items will be loaded here -->
                <?php
                $galleryItems = [
                    ['id' => 1, 'category' => 'wildlife', 'title' => 'Masai Mara Lion', 'image' => 'lionmara.jpg'],
                    ['id' => 2, 'category' => 'landscape', 'title' => 'Kilimanjaro Sunrise', 'image' => 'kilimanjaro sunrise.jfif'],
                    ['id' => 3, 'category' => 'wildlife', 'title' => 'Amboseli Elephants', 'image' => 'elephants at amboseli.jpg'],
                    ['id' => 4, 'category' => 'cultural', 'title' => 'Maasai Warrior', 'image' => 'maasai worriors.jpeg'],
                    ['id' => 5, 'category' => 'safari-life', 'title' => 'Game Drive', 'image' => 'game drive.jpeg'],
                    ['id' => 6, 'category' => 'sunset', 'title' => 'Savannah Sunrise', 'image' => 'sunset.jpg'],
                    ['id' => 7, 'category' => 'wildlife', 'title' => 'Hyena Hunt', 'image' => 'hyena hunt.jpg'],
                    ['id' => 8, 'category' => 'landscape', 'title' => 'Great Rift Valley', 'image' => 'great rift valley.jfif'],
                    ['id' => 9, 'category' => 'cultural', 'title' => 'Samburu Dance', 'image' => 'samburu dance.jpg'],
                    ['id' => 10, 'category' => 'wildlife', 'title' => 'Nairobi Giraffes', 'image' => 'Giraffe-at-Nairobi-National-Park.webp'],
                    ['id' => 11, 'category' => 'safari-life', 'title' => 'Bush Breakfast', 'image' => 'bush breakfast.jfif'],
                    ['id' => 12, 'category' => 'sunset', 'title' => 'Mara River Sunset', 'image' => 'mara river sunset.jfif'],
                    ['id' => 13, 'category' => 'wildlife', 'title' => 'Samburu National Park', 'image' => 'samburu national park.jpg'],
                    ['id' => 14, 'category' => 'landscape', 'title' => 'Tsavo Red Elephants', 'image' => '1674110151_39_wildlife-3233525_1280.jpg'],
                    ['id' => 15, 'category' => 'cultural', 'title' => 'The team', 'image' => 'people.jpeg'],
                ];
                
                foreach ($galleryItems as $item) {
                    echo '
                    <div class="gallery-item" data-category="' . $item['category'] . '">
                        <div class="gallery-img">
                            <img src="assets/images/' . $item['image'] . '" alt="' . $item['title'] . '">
                            <div class="gallery-overlay">
                                <div class="gallery-info">
                                    <h3>' . $item['title'] . '</h3>
                                    <p>' . ucfirst(str_replace('-', ' ', $item['category'])) . '</p>
                                </div>
                                <div class="gallery-actions">
                                    <button class="view-btn" data-id="' . $item['id'] . '">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <a href="assets/images/gallery/' . $item['image'] . '" class="download-btn" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
            
            <div class="load-more-container">
                <button class="load-more-btn" id="loadMore">
                    <i class="fas fa-plus"></i> Load More Photos
                </button>
            </div>
        </div>
    </section>

    <!-- Video Gallery -->
    <section class="video-gallery">
        <div class="container">
            <div class="section-header">
                <h2>Safari Videos</h2>
                <p>Experience the sights and sounds of Kenyan wildlife</p>
            </div>
            
            <div class="video-grid">
                <div class="video-card">
                    <div class="video-thumbnail">
<iframe width="853" height="480" src="https://www.youtube.com/embed/oTw4XnLnSmU" title="The Great Migration - Wildebeest Migration from the Serengeti to the Masai Mara, Crossing Mara River" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <img src="assets/images/videos/migration-thumb.jpg" alt="Great Migration">
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <h3>The Great Migration</h3>
                        <p>Witness millions of wildebeest crossing the Mara River</p>
                        <span class="video-duration">4:45</span>
                    </div>
                </div>
                
                <div class="video-card">
                    <div class="video-thumbnail">
                        <iframe width="853" height="480" src="https://www.youtube.com/embed/K7SR0_rhMSo" title="How a Lion Pride Hunts Prey | Cat Attack-tics" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        <img src="assets/images/videos/lion-hunt-thumb.jpg" alt="Lion Hunt">
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <h3>Lion Hunt Sequence</h3>
                        <p>Rare footage of lions hunting in Masai Mara</p>
                        <span class="video-duration">4:20</span>
                    </div>
                </div>
                
                <div class="video-card">
                    <div class="video-thumbnail">
                        <iframe width="315" height="576" src="https://www.youtube.com/embed/egIe4k3wc5w" title="Experience authentic Maasai culture in action. Would you try this? #africa #culture #adventure" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        <img src="assets/images/videos/maasai worriors dance" alt="Cultural Experience">
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <h3>Maasai Cultural Experience</h3>
                        <p>Traditional dances and ceremonies</p>
                        <span class="video-duration">3:15</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal">
        <div class="lightbox-content">
            <button class="lightbox-close" id="closeLightbox">
                <i class="fas fa-times"></i>
            </button>
            <button class="lightbox-nav prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="lightbox-nav next">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="lightbox-image-container">
                <img id="lightboxImage" src="" alt="">
                <div class="lightbox-caption">
                    <h3 id="lightboxTitle"></h3>
                    <p id="lightboxCategory"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/gallery.js"></script>
</body>
</html>