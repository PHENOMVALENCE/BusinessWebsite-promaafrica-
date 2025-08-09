<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

// Handle status update
if (isset($_POST['update_status'])) {
    try {
        $stmt = $db->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], $_POST['inquiry_id']]);
        $success = "Inquiry status updated successfully.";
    } catch (PDOException $e) {
        $error = "Error updating status: " . $e->getMessage();
    }
}

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    try {
        $stmt = $db->prepare("DELETE FROM inquiries WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $success = "Inquiry deleted successfully.";
    } catch (PDOException $e) {
        $error = "Error deleting inquiry: " . $e->getMessage();
    }
}

// Handle bulk actions
if (isset($_POST['bulk_action']) && !empty($_POST['selected_inquiries'])) {
    $action = $_POST['bulk_action'];
    $selected_ids = $_POST['selected_inquiries'];
    
    try {
        if ($action === 'delete') {
            $placeholders = str_repeat('?,', count($selected_ids) - 1) . '?';
            $stmt = $db->prepare("DELETE FROM inquiries WHERE id IN ($placeholders)");
            $stmt->execute($selected_ids);
            $success = count($selected_ids) . " inquiries deleted successfully.";
        } elseif ($action === 'mark_read') {
            $placeholders = str_repeat('?,', count($selected_ids) - 1) . '?';
            $stmt = $db->prepare("UPDATE inquiries SET status = 'read' WHERE id IN ($placeholders)");
            $stmt->execute($selected_ids);
            $success = count($selected_ids) . " inquiries marked as read.";
        }
    } catch (PDOException $e) {
        $error = "Error performing bulk action: " . $e->getMessage();
    }
}

// Get filters
$search = trim($_GET['search'] ?? '');
$status_filter = $_GET['status'] ?? '';
$property_filter = $_GET['property'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 15;

// Build query
$conditions = [];
$params = [];

if (!empty($search)) {
    $conditions[] = "(name LIKE ? OR email LIKE ? OR message LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($status_filter)) {
    $conditions[] = "i.status = ?";
    $params[] = $status_filter;
}

if (!empty($property_filter)) {
    $conditions[] = "i.property_id = ?";
    $params[] = $property_filter;
}

if (!empty($date_from)) {
    $conditions[] = "DATE(i.created_at) >= ?";
    $params[] = $date_from;
}

if (!empty($date_to)) {
    $conditions[] = "DATE(i.created_at) <= ?";
    $params[] = $date_to;
}

$where_clause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

try {
    // Get total count
    $count_sql = "SELECT COUNT(*) FROM inquiries i $where_clause";
    $count_stmt = $db->prepare($count_sql);
    $count_stmt->execute($params);
    $total_inquiries = $count_stmt->fetchColumn();
    $total_pages = ceil($total_inquiries / $per_page);
    
    // Get inquiries
    $offset = ($page - 1) * $per_page;
    $sql = "
        SELECT i.*, p.title as property_title 
        FROM inquiries i 
        LEFT JOIN properties p ON i.property_id = p.id 
        $where_clause 
        ORDER BY i.created_at DESC 
        LIMIT $per_page OFFSET $offset
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $inquiries = $stmt->fetchAll();
    
    // Get properties for filter dropdown
    $properties_stmt = $db->query("SELECT id, title FROM properties ORDER BY title");
    $properties = $properties_stmt->fetchAll();
    
} catch (PDOException $e) {
    $inquiries = [];
    $properties = [];
    $total_inquiries = 0;
    $total_pages = 0;
    $error = "Error fetching inquiries: " . $e->getMessage();
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries - Property CMS</title>
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
                    <h1>Inquiries</h1>
                    <div class="page-actions">
                        <span class="inquiry-count"><?php echo number_format($total_inquiries); ?> total inquiries</span>
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
                                <input type="text" name="search" placeholder="Search inquiries..." 
                                       value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            
                            <div class="filter-group">
                                <select name="status">
                                    <option value="">All Status</option>
                                    <option value="new" <?php echo $status_filter === 'new' ? 'selected' : ''; ?>>New</option>
                                    <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Read</option>
                                    <option value="replied" <?php echo $status_filter === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <select name="property">
                                    <option value="">All Properties</option>
                                    <?php foreach ($properties as $property): ?>
                                        <option value="<?php echo $property['id']; ?>" 
                                                <?php echo $property_filter == $property['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($property['title']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <input type="date" name="date_from" placeholder="From Date" 
                                       value="<?php echo htmlspecialchars($date_from); ?>">
                            </div>
                            
                            <div class="filter-group">
                                <input type="date" name="date_to" placeholder="To Date" 
                                       value="<?php echo htmlspecialchars($date_to); ?>">
                            </div>
                            
                            <button type="submit" class="btn-search">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Bulk Actions -->
                <form method="POST" id="bulkForm">
                    <div class="bulk-actions">
                        <select name="bulk_action" id="bulkAction">
                            <option value="">Bulk Actions</option>
                            <option value="mark_read">Mark as Read</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" class="btn-secondary" onclick="return confirmBulkAction()">Apply</button>
                    </div>
                    
                    <!-- Inquiries Table -->
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th>Contact</th>
                                    <th>Property</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($inquiries)): ?>
                                    <tr>
                                        <td colspan="7" class="no-data">No inquiries found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($inquiries as $inquiry): ?>
                                        <tr class="inquiry-row <?php echo $inquiry['status'] === 'new' ? 'unread' : ''; ?>">
                                            <td>
                                                <input type="checkbox" name="selected_inquiries[]" 
                                                       value="<?php echo $inquiry['id']; ?>" class="inquiry-checkbox">
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <h4><?php echo htmlspecialchars($inquiry['name']); ?></h4>
                                                    <p>
                                                        <i class="fas fa-envelope"></i>
                                                        <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>">
                                                            <?php echo htmlspecialchars($inquiry['email']); ?>
                                                        </a>
                                                    </p>
                                                    <?php if ($inquiry['phone']): ?>
                                                        <p>
                                                            <i class="fas fa-phone"></i>
                                                            <a href="tel:<?php echo htmlspecialchars($inquiry['phone']); ?>">
                                                                <?php echo htmlspecialchars($inquiry['phone']); ?>
                                                            </a>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($inquiry['property_title']): ?>
                                                    <a href="../sales.php?view=<?php echo $inquiry['property_id']; ?>" target="_blank">
                                                        <?php echo htmlspecialchars($inquiry['property_title']); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">General Inquiry</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="message-preview">
                                                    <?php echo nl2br(htmlspecialchars(substr($inquiry['message'], 0, 100))); ?>
                                                    <?php if (strlen($inquiry['message']) > 100): ?>
                                                        <span class="text-muted">...</span>
                                                        <button type="button" class="btn-link" onclick="showFullMessage(<?php echo $inquiry['id']; ?>)">
                                                            Read More
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <form method="POST" class="inline-form">
                                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                                    <select name="status" onchange="this.form.submit()" class="status-select">
                                                        <option value="new" <?php echo $inquiry['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                                        <option value="read" <?php echo $inquiry['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                                        <option value="replied" <?php echo $inquiry['status'] === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                                    </select>
                                                    <input type="hidden" name="update_status" value="1">
                                                </form>
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <?php echo date('M j, Y', strtotime($inquiry['created_at'])); ?>
                                                    <small><?php echo date('g:i A', strtotime($inquiry['created_at'])); ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-view" 
                                                            onclick="viewInquiry(<?php echo $inquiry['id']; ?>)" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>?subject=Re: Property Inquiry" 
                                                       class="btn-action btn-reply" title="Reply">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    
                                                    <a href="?delete=<?php echo $inquiry['id']; ?>" 
                                                       class="btn-action btn-delete" title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this inquiry?')">
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
                </form>
                
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
    
    <!-- Inquiry Detail Modal -->
    <div id="inquiryModal" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h3>Inquiry Details</h3>
                <button class="modal-close" onclick="closeInquiryModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="inquiryDetails">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
    
    <script src="admin-scripts.js"></script>
    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.inquiry-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }
        
        function confirmBulkAction() {
            const action = document.getElementById('bulkAction').value;
            const selected = document.querySelectorAll('.inquiry-checkbox:checked');
            
            if (!action) {
                alert('Please select an action.');
                return false;
            }
            
            if (selected.length === 0) {
                alert('Please select at least one inquiry.');
                return false;
            }
            
            const actionText = action === 'delete' ? 'delete' : 'mark as read';
            return confirm(`Are you sure you want to ${actionText} ${selected.length} selected inquiries?`);
        }
        
        function viewInquiry(inquiryId) {
            // In a real implementation, this would fetch inquiry details via AJAX
            const modal = document.getElementById('inquiryModal');
            const details = document.getElementById('inquiryDetails');
            
            details.innerHTML = '<div class="loading">Loading inquiry details...</div>';
            modal.style.display = 'flex';
            
            // Simulate loading inquiry details
            setTimeout(() => {
                details.innerHTML = `
                    <div class="inquiry-detail">
                        <h4>Inquiry #${inquiryId}</h4>
                        <p>Full inquiry details would be loaded here via AJAX.</p>
                    </div>
                `;
            }, 500);
        }
        
        function closeInquiryModal() {
            document.getElementById('inquiryModal').style.display = 'none';
        }
        
        function showFullMessage(inquiryId) {
            // Implementation for showing full message
            alert('Full message view would be implemented here.');
        }
        
        // Close modal when clicking overlay
        document.querySelector('.modal-overlay').addEventListener('click', closeInquiryModal);
    </script>
</body>
</html>
