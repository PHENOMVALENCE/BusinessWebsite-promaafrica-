<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

// Get dashboard statistics
try {
    $stats = [];
    
    // Total properties
    $stmt = $db->query("SELECT COUNT(*) as total FROM properties");
    $stats['total_properties'] = $stmt->fetchColumn();
    
    // Available properties
    $stmt = $db->query("SELECT COUNT(*) as available FROM properties WHERE status = 'available'");
    $stats['available_properties'] = $stmt->fetchColumn();
    
    // Featured properties
    $stmt = $db->query("SELECT COUNT(*) as featured FROM properties WHERE featured = 1");
    $stats['featured_properties'] = $stmt->fetchColumn();
    
    // Total inquiries
    $stmt = $db->query("SELECT COUNT(*) as total FROM inquiries");
    $stats['total_inquiries'] = $stmt->fetchColumn();
    
    // New inquiries
    $stmt = $db->query("SELECT COUNT(*) as new FROM inquiries WHERE status = 'new'");
    $stats['new_inquiries'] = $stmt->fetchColumn();
    
    // Recent properties
    $stmt = $db->query("SELECT * FROM properties ORDER BY created_at DESC LIMIT 5");
    $recent_properties = $stmt->fetchAll();
    
    // Recent inquiries
    $stmt = $db->query("
        SELECT i.*, p.title as property_title 
        FROM inquiries i 
        LEFT JOIN properties p ON i.property_id = p.id 
        ORDER BY i.created_at DESC LIMIT 5
    ");
    $recent_inquiries = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $stats = [];
    $recent_properties = [];
    $recent_inquiries = [];
    error_log("Dashboard error: " . $e->getMessage());
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Property CMS</title>
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
                    <h1>Dashboard</h1>
                    <p>Welcome back, <?php echo htmlspecialchars($user['full_name']); ?>!</p>
                </div>
                
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['total_properties'] ?? 0); ?></h3>
                            <p>Total Properties</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['available_properties'] ?? 0); ?></h3>
                            <p>Available</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['featured_properties'] ?? 0); ?></h3>
                            <p>Featured</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($stats['new_inquiries'] ?? 0); ?></h3>
                            <p>New Inquiries</p>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="dashboard-grid">
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Recent Properties</h2>
                            <a href="properties.php" class="btn-link">View All</a>
                        </div>
                        
                        <div class="recent-items">
                            <?php if (empty($recent_properties)): ?>
                                <p class="no-data">No properties found.</p>
                            <?php else: ?>
                                <?php foreach ($recent_properties as $property): ?>
                                    <div class="recent-item">
                                        <div class="item-info">
                                            <h4><?php echo htmlspecialchars($property['title']); ?></h4>
                                            <p><?php echo htmlspecialchars($property['location']); ?> • TZS <?php echo number_format($property['price']); ?></p>
                                            <span class="item-date"><?php echo date('M j, Y', strtotime($property['created_at'])); ?></span>
                                        </div>
                                        <div class="item-status">
                                            <span class="status-badge status-<?php echo $property['status']; ?>">
                                                <?php echo ucfirst($property['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="dashboard-section">
                        <div class="section-header">
                            <h2>Recent Inquiries</h2>
                            <a href="inquiries.php" class="btn-link">View All</a>
                        </div>
                        
                        <div class="recent-items">
                            <?php if (empty($recent_inquiries)): ?>
                                <p class="no-data">No inquiries found.</p>
                            <?php else: ?>
                                <?php foreach ($recent_inquiries as $inquiry): ?>
                                    <div class="recent-item">
                                        <div class="item-info">
                                            <h4><?php echo htmlspecialchars($inquiry['name']); ?></h4>
                                            <p><?php echo htmlspecialchars($inquiry['property_title'] ?? 'General Inquiry'); ?></p>
                                            <span class="item-date"><?php echo date('M j, Y', strtotime($inquiry['created_at'])); ?></span>
                                        </div>
                                        <div class="item-status">
                                            <span class="status-badge status-<?php echo $inquiry['status']; ?>">
                                                <?php echo ucfirst($inquiry['status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="admin-scripts.js"></script>
</body>
</html>
