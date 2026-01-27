<?php
session_start();
require_once '../../includes/database.php';
require_once '../../includes/auth.php';
checkAdminLogin();

$page_title = 'Edit Tour';
$current_page = 'tours';

// Get tour ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$tour_id = (int)$_GET['id'];

// Fetch tour data
$sql = "SELECT * FROM tours WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $tour_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$tour = mysqli_fetch_assoc($result);

if (!$tour) {
    header('Location: index.php');
    exit;
}

// Decode JSON fields
$includes = json_decode($tour['includes'] ?? '[]', true);
$excludes = json_decode($tour['excludes'] ?? '[]', true);
$highlights = json_decode($tour['highlights'] ?? '[]', true);
?>

<?php include '../includes/header.php'; ?>

<div class="admin-container">
    <?php include '../includes/sidebar.php'; ?>
    
    <main class="admin-main">
        <div class="admin-header">
            <h1>Edit Tour: <?php echo htmlspecialchars($tour['title']); ?></h1>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Tours
            </a>
        </div>
        
        <form id="editTourForm" class="admin-form" enctype="multipart/form-data">
            <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
            
            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="form-section">
                        <h3>Basic Information</h3>
                        
                        <div class="form-group">
                            <label for="title">Tour Title *</label>
                            <input type="text" id="title" name="title" required 
                                   value="<?php echo htmlspecialchars($tour['title']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="slug">URL Slug *</label>
                            <input type="text" id="slug" name="slug" required 
                                   value="<?php echo htmlspecialchars($tour['slug']); ?>">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="duration">Duration *</label>
                                <input type="text" id="duration" name="duration" required 
                                       value="<?php echo htmlspecialchars($tour['duration']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="category">Category *</label>
                                <select id="category" name="category" required>
                                    <option value="wildlife" <?php echo $tour['category'] == 'wildlife' ? 'selected' : ''; ?>>Wildlife Safari</option>
                                    <option value="cultural" <?php echo $tour['category'] == 'cultural' ? 'selected' : ''; ?>>Cultural Experience</option>
                                    <option value="adventure" <?php echo $tour['category'] == 'adventure' ? 'selected' : ''; ?>>Adventure</option>
                                    <option value="luxury" <?php echo $tour['category'] == 'luxury' ? 'selected' : ''; ?>>Luxury Safari</option>
                                    <option value="family" <?php echo $tour['category'] == 'family' ? 'selected' : ''; ?>>Family Friendly</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="price">Regular Price ($) *</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" required
                                       value="<?php echo $tour['price']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="discount_price">Discount Price ($)</label>
                                <input type="number" id="discount_price" name="discount_price" step="0.01" min="0"
                                       value="<?php echo $tour['discount_price']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="difficulty">Difficulty Level</label>
                                <select id="difficulty" name="difficulty">
                                    <option value="Easy" <?php echo $tour['difficulty'] == 'Easy' ? 'selected' : ''; ?>>Easy</option>
                                    <option value="Moderate" <?php echo $tour['difficulty'] == 'Moderate' ? 'selected' : ''; ?>>Moderate</option>
                                    <option value="Challenging" <?php echo $tour['difficulty'] == 'Challenging' ? 'selected' : ''; ?>>Challenging</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="max_participants">Max Participants</label>
                                <input type="number" id="max_participants" name="max_participants" min="1" max="50"
                                       value="<?php echo $tour['max_participants']; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Tour Images</h3>
                        
                        <div class="form-group">
                            <label>Current Main Image</label>
                            <div class="current-image">
                                <img src="../../assets/images/tours/<?php echo basename($tour['image_path']); ?>" 
                                     alt="Current tour image">
                                <span class="image-name"><?php echo basename($tour['image_path']); ?></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="main_image">Change Main Image</label>
                            <div class="file-upload">
                                <input type="file" id="main_image" name="main_image" accept="image/*">
                                <div class="upload-preview" id="mainImagePreview">
                                    <i class="fas fa-camera"></i>
                                    <span>Click to change image</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="form-column">
                    <div class="form-section">
                        <h3>Tour Description</h3>
                        
                        <div class="form-group">
                            <label for="short_description">Short Description *</label>
                            <textarea id="short_description" name="short_description" rows="3" required><?php echo htmlspecialchars($tour['short_description']); ?></textarea>
                            <div class="char-count">
                                <span id="shortDescCount"><?php echo strlen($tour['short_description']); ?></span>/500 characters
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Full Description *</label>
                            <textarea id="description" name="description" rows="8" required><?php echo htmlspecialchars($tour['description']); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>Tour Details</h3>
                        
                        <div class="form-group">
                            <label>What's Included</label>
                            <div class="multi-input">
                                <div class="input-with-button">
                                    <input type="text" id="includeInput" placeholder="e.g., Accommodation">
                                    <button type="button" id="addInclude" class="btn-small">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                                <div class="input-list" id="includesList">
                                    <?php foreach ($includes as $include): ?>
                                    <div class="list-item">
                                        <span><?php echo htmlspecialchars($include); ?></span>
                                        <button type="button" class="remove-item">&times;</button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="includes" id="includes" 
                                       value='<?php echo json_encode($includes); ?>'>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>What's Excluded</label>
                            <div class="multi-input">
                                <div class="input-with-button">
                                    <input type="text" id="excludeInput" placeholder="e.g., International flights">
                                    <button type="button" id="addExclude" class="btn-small">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                                <div class="input-list" id="excludesList">
                                    <?php foreach ($excludes as $exclude): ?>
                                    <div class="list-item">
                                        <span><?php echo