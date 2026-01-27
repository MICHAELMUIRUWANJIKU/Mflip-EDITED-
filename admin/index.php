<?php
session_start();
require_once '../includes/database.php';
require_once '../includes/auth.php';

// Check if admin is logged in
checkAdminLogin();

$page_title = 'Manage Tours';
$current_page = 'tours';
?>

<?php include '../includes/header.php'; ?>

<div class="admin-container">
    <?php include '../includes/sidebar.php'; ?>
    
    <main class="admin-main">
        <div class="admin-header">
            <h1>Manage Tours</h1>
            <a href="add.php" class="btn-add">
                <i class="fas fa-plus"></i> Add New Tour
            </a>
        </div>
        
        <!-- Filters -->
        <div class="admin-filters">
            <div class="filter-group">
                <select id="categoryFilter" class="filter-select">
                    <option value="">All Categories</option>
                    <option value="wildlife">Wildlife</option>
                    <option value="cultural">Cultural</option>
                    <option value="adventure">Adventure</option>
                    <option value="luxury">Luxury</option>
                    <option value="family">Family</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="statusFilter" class="filter-select">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                    <option value="featured">Featured</option>
                </select>
            </div>
            <button class="btn-export">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
        
        <!-- Tours Table -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tour</th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Bookings</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Pagination
                    $limit = 10;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    
                    // Build query with filters
                    $where = [];
                    $params = [];
                    $types = '';
                    
                    if (isset($_GET['category']) && $_GET['category'] != '') {
                        $where[] = "category = ?";
                        $params[] = $_GET['category'];
                        $types .= 's';
                    }
                    
                    if (isset($_GET['status']) && $_GET['status'] != '') {
                        if ($_GET['status'] == 'available') {
                            $where[] = "available = 1";
                        } elseif ($_GET['status'] == 'unavailable') {
                            $where[] = "available = 0";
                        } elseif ($_GET['status'] == 'featured') {
                            $where[] = "featured = 1";
                        }
                    }
                    
                    $where_sql = '';
                    if (!empty($where)) {
                        $where_sql = 'WHERE ' . implode(' AND ', $where);
                    }
                    
                    // Count total
                    $count_sql = "SELECT COUNT(*) as total FROM tours $where_sql";
                    $count_result = mysqli_prepare($conn, $count_sql);
                    if (!empty($params)) {
                        mysqli_stmt_bind_param($count_result, $types, ...$params);
                    }
                    mysqli_stmt_execute($count_result);
                    $count_data = mysqli_stmt_get_result($count_result)->fetch_assoc();
                    $total_tours = $count_data['total'];
                    $total_pages = ceil($total_tours / $limit);
                    
                    // Fetch tours
                    $sql = "SELECT t.*, 
                           (SELECT COUNT(*) FROM bookings WHERE tour_id = t.id) as booking_count
                           FROM tours t 
                           $where_sql 
                           ORDER BY created_at DESC 
                           LIMIT ? OFFSET ?";
                    
                    $params[] = $limit;
                    $params[] = $offset;
                    $types .= 'ii';
                    
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($tour = mysqli_fetch_assoc($result)) {
                            $status_class = $tour['available'] ? 'status-available' : 'status-unavailable';
                            $status_text = $tour['available'] ? 'Available' : 'Unavailable';
                            
                            if ($tour['featured']) {
                                $status_class = 'status-featured';
                                $status_text = 'Featured';
                            }
                            ?>
                            <tr>
                                <td>#<?php echo $tour['id']; ?></td>
                                <td>
                                    <div class="tour-info-cell">
                                        <div class="tour-image-small" 
                                             style="background-image: url('../../assets/images/tours/<?php echo basename($tour['image_path']); ?>');"></div>
                                        <div>
                                            <strong><?php echo htmlspecialchars($tour['title']); ?></strong>
                                            <small><?php echo substr($tour['short_description'], 0, 60) . '...'; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $tour['category']; ?>">
                                        <?php echo ucfirst($tour['category']); ?>
                                    </span>
                                </td>
                                <td><?php echo $tour['duration']; ?></td>
                                <td>
                                    <strong class="price">$<?php echo number_format($tour['price'], 2); ?></strong>
                                    <?php if ($tour['discount_price']): ?>
                                        <br><small class="discount">$<?php echo number_format($tour['discount_price'], 2); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <?php echo $status_text; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="booking-count"><?php echo $tour['booking_count']; ?></span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit.php?id=<?php echo $tour['id']; ?>" class="btn-action btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../../tour-details.php?slug=<?php echo $tour['slug']; ?>" target="_blank" class="btn-action btn-view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn-action btn-delete" 
                                                data-id="<?php echo $tour['id']; ?>" 
                                                data-title="<?php echo htmlspecialchars($tour['title']); ?>"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="8" class="no-data">No tours found. <a href="add.php">Add your first tour</a></td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?>" class="page-link">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                <?php endif; ?>
                
                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);
                
                for ($i = $start; $i <= $end; $i++):
                ?>
                    <a href="?page=<?php echo $i; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?>" 
                       class="page-link <?php echo $i == $page ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['status']) ? '&status=' . $_GET['status'] : ''; ?>" class="page-link">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete tour: <strong id="deleteTourTitle"></strong>?</p>
            <p class="text-warning"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone!</p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary modal-close">Cancel</button>
            <button class="btn-danger" id="confirmDelete">Delete Tour</button>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<script src="../js/tours.js"></script>