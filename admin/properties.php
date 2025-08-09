<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $stmt = $db->prepare("DELETE FROM properties WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $success = "Property deleted successfully.";
    } catch (PDOException $e) {
        $error = "Error deleting property: " . $e->getMessage();
    }
}

// Handle status update
if (isset($_POST['update_status'])) {
    try {
        $stmt = $db->prepare("UPDATE properties SET status = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], $_POST['property_id']]);
        $success = "Property status updated successfully.";
    } catch (PDOException $e) {
        $error = "Error updating status: " . $e->getMessage();
    }
}

// Get filters
$search = trim($_GET['search'] ?? '');
$status_filter = $_GET['status'] ?? '';
$type_filter = $_GET['type'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 10;

// Build query
$conditions = [];
$params = [];

if (!empty($search)) {
    $conditions[] = "(title LIKE ? OR location LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($status_filter)) {
    $conditions[] = "status = ?";
    $params[] = $status_filter;
}

if (!empty($type_filter)) {
    $conditions[] = "property_type = ?";
    $params[] = $type_filter;
}

$where_clause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

try {
    // Get total count
    $count_sql = "SELECT COUNT(*) FROM properties $where_clause";
    $count_stmt = $db->prepare($count_sql);
    $count_stmt->execute($params);
    $total_properties = $count_stmt->fetchColumn();
    $total_pages = ceil($total_properties / $per_page);
    
    // Get properties
    $offset = ($page - 1) * $per_page;
    $sql = "SELECT * FROM properties $where_clause ORDER BY created_at DESC LIMIT $per_page OFFSET $offset";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $properties = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $properties = [];
    $total_properties = 0;
    $total_pages = 0;
    $error = "Error fetching properties: " . $e->getMessage();
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties - Property CMS</title>
    <link rel="stylesheet" href="admin-styles.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="content-area">
                <div class="page-header">
                    <h1>Properties</h1>
                    <div class="page-actions">
                        <a href="add-property.php" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            Add Property
                        </a>
                    </div>
                </div>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <!-- Filters -->
                <div class="filters-section">
                    <form method="GET" class="filters-form">
                        <div class="filter-row">
                            <div class="filter-group">
                                <input type="text" name="search" placeholder="Search properties..." 
                                       value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            
                            <div class="filter-group">
                                <select name="status">
                                    <option value="">All Status</option>
                                    <option value="available" <?php echo $status_filter === 'available' ? 'selected' : ''; ?>>Available</option>
                                    <option value="sold" <?php echo $status_filter === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                    <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <select name="type">
                                    <option value="">All Types</option>
                                    <option value="house" <?php echo $type_filter === 'house' ? 'selected' : ''; ?>>House</option>
                                    <option value="apartment" <?php echo $type_filter === 'apartment' ? 'selected' : ''; ?>>Apartment</option>
                                    <option value="land" <?php echo $type_filter === 'land' ? 'selected' : ''; ?>>Land</option>
                                    <option value="commercial" <?php echo $type_filter === 'commercial' ? 'selected' : ''; ?>>Commercial</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-search">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Properties Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($properties)): ?>
                                <tr>
                                    <td colspan="8" class="no-data">No properties found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($properties as $property): ?>
                                    <tr>
                                        <td>
                                            <div class="property-info">
                                                <h4><?php echo htmlspecialchars($property['title']); ?></h4>
                                                <?php if ($property['featured']): ?>
                                                    <span class="featured-badge">Featured</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?php echo ucfirst(htmlspecialchars($property['property_type'])); ?></td>
                                        <td><?php echo htmlspecialchars($property['location']); ?></td>
                                        <td>TZS <?php echo number_format($property['price']); ?></td>
                                        <td>
                                            <form method="POST" class="inline-form">
                                                <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
                                                <select name="status" onchange="this.form.submit()">
                                                    <option value="available" <?php echo $property['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                                                    <option value="sold" <?php echo $property['status'] === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                                    <option value="pending" <?php echo $property['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                </select>
                                                <input type="hidden" name="update_status" value="1">
                                            </form>
                                        </td>
                                        <td><?php echo number_format($property['views']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($property['created_at'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="../sales.php?view=<?php echo $property['id']; ?>" target="_blank" 
                                                   class="btn-action btn-view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="edit-property.php?id=<?php echo $property['id']; ?>" 
                                                   class="btn-action btn-edit" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="?delete=<?php echo $property['id']; ?>" 
                                                   class="btn-action btn-delete" title="Delete"
                                                   onclick="return confirm('Are you sure you want to delete this property?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>&<?php echo http_build_query(array_filter($_GET, function($k) { return $k !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>" 
                               class="pagination-btn">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <?php if ($i === $page): ?>
                                <span class="pagination-btn active"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a href="?page=<?php echo $i; ?>&<?php echo http_build_query(array_filter($_GET, function($k) { return $k !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>" 
                                   class="pagination-btn"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>&<?php echo http_build_query(array_filter($_GET, function($k) { return $k !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>" 
                               class="pagination-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="admin-scripts.js"></script>
</body>
</html>
