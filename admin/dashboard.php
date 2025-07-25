<?php
session_start();
require_once '../database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Get comprehensive dashboard statistics
try {
    $pdo = getConnection();
    
    // Property statistics
    $propertyStats = $pdo->query("SELECT 
        COUNT(*) as total_properties,
        SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available_properties,
        SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_properties,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_properties,
        SUM(CASE WHEN featured = 1 THEN 1 ELSE 0 END) as featured_properties,
        COALESCE(SUM(views), 0) as total_views,
        COALESCE(SUM(inquiries), 0) as total_inquiries,
        COALESCE(AVG(price), 0) as avg_price
        FROM properties")->fetch();
    
    // Recent inquiries
    $recentInquiries = $pdo->query("SELECT pi.*, p.title as property_title 
        FROM property_inquiries pi 
        LEFT JOIN properties p ON pi.property_id = p.id 
        ORDER BY pi.created_at DESC 
        LIMIT 5")->fetchAll();
    
    // Top performing properties
    $topProperties = $pdo->query("SELECT id, title, location, views, inquiries, status, featured 
        FROM properties 
        ORDER BY (COALESCE(views, 0) + COALESCE(inquiries, 0) * 2) DESC 
        LIMIT 5")->fetchAll();
    
    // Recent properties
    $recentProperties = $pdo->query("SELECT id, title, location, price, status, featured, created_at 
        FROM properties 
        ORDER BY created_at DESC 
        LIMIT 5")->fetchAll();
    
} catch(PDOException $e) {
    $error = "Error loading dashboard data: " . $e->getMessage();
    $propertyStats = ['total_properties' => 0, 'available_properties' => 0, 'sold_properties' => 0, 'pending_properties' => 0, 'featured_properties' => 0, 'total_views' => 0, 'total_inquiries' => 0, 'avg_price' => 0];
    $recentInquiries = [];
    $topProperties = [];
    $recentProperties = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Proma Africa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #f6ae01;
            --primary-hover: #e29f01;
            --secondary-color: #0056b3;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
            --text-dark: #1a1a1a;
            --text-medium: #4a4a4a;
            --text-light: #666666;
            --text-muted: #8e8e8e;
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-light: #f1f3f5;
            --border-color: #e1e5e9;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.12);
            --border-radius-sm: 6px;
            --border-radius-md: 10px;
            --border-radius-lg: 16px;
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--text-dark) 0%, #2c3e50 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: var(--transition-normal);
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .sidebar-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition-normal);
            position: relative;
        }

        .nav-link:hover,
        .nav-item.active .nav-link {
            background: rgba(246, 174, 1, 0.1);
            color: var(--primary-color);
        }

        .nav-link i {
            width: 20px;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .nav-badge {
            background: var(--primary-color);
            color: var(--text-dark);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: auto;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--text-dark);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.7;
        }

        .logout-btn {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            padding: 8px;
            border-radius: var(--border-radius-sm);
            transition: var(--transition-normal);
        }

        .logout-btn:hover {
            color: var(--primary-color);
            background: rgba(246, 174, 1, 0.1);
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
        }

        .admin-header {
            background: var(--bg-primary);
            padding: 20px 30px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-medium);
            cursor: pointer;
        }

        .admin-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-stats {
            display: flex;
            gap: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-medium);
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 10px 20px;
            border-radius: var(--border-radius-sm);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition-normal);
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--bg-light);
            color: var(--text-medium);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
        }

        /* Content Area */
        .admin-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* Statistics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--bg-primary);
            padding: 25px;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
            transition: var(--transition-normal);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
        }

        .stat-card.success::before { background: var(--success-color); }
        .stat-card.danger::before { background: var(--danger-color); }
        .stat-card.warning::before { background: var(--warning-color); }
        .stat-card.info::before { background: var(--info-color); }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: var(--primary-color);
        }

        .stat-card.success .stat-icon { background: var(--success-color); }
        .stat-card.danger .stat-icon { background: var(--danger-color); }
        .stat-card.warning .stat-icon { background: var(--warning-color); }
        .stat-card.info .stat-icon { background: var(--info-color); }

        .stat-content h3 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .stat-content p {
            color: var(--text-medium);
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* Quick Actions */
        .quick-actions {
            margin-bottom: 40px;
        }

        .quick-actions h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .action-card {
            background: var(--bg-primary);
            padding: 20px;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            text-decoration: none;
            color: var(--text-dark);
            transition: var(--transition-normal);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .action-content h4 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .action-content p {
            font-size: 0.85rem;
            color: var(--text-medium);
        }

        /* Tables */
        .dashboard-tables {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .table-section {
            background: var(--bg-primary);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .table-header {
            padding: 20px 25px;
            background: var(--bg-light);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 1.1rem;
            color: var(--text-dark);
        }

        .btn-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table th {
            background: var(--bg-light);
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .data-table td {
            color: var(--text-medium);
            font-size: 0.9rem;
        }

        .data-table tr:hover {
            background: var(--bg-light);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.new {
            background: rgba(52, 152, 219, 0.1);
            color: var(--info-color);
        }

        .status-badge.read {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
        }

        .status-badge.available {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
        }

        .status-badge.sold {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }

        .status-badge.pending {
            background: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
        }

        .featured-mini {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--primary-color);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .table-actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 10px;
            border: none;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            font-size: 0.8rem;
            transition: var(--transition-normal);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-action.view {
            background: var(--info-color);
            color: white;
        }

        .btn-action.edit {
            background: var(--warning-color);
            color: white;
        }

        .btn-action.delete {
            background: var(--danger-color);
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .empty-state-mini {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .empty-state-mini i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-tables {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .header-stats {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .admin-header {
                padding: 15px 20px;
            }

            .admin-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <img src="../2.png" alt="Proma Africa" class="sidebar-logo">
                <h3>Admin Panel</h3>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item active">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="properties.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Properties</span>
                            <span class="nav-badge"><?php echo $propertyStats['total_properties']; ?></span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="add-property.php" class="nav-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Property</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="inquiries.php" class="nav-link">
                            <i class="fas fa-envelope"></i>
                            <span>Inquiries</span>
                            <span class="nav-badge"><?php echo count($recentInquiries); ?></span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="analytics.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <div class="admin-user">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?>
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Bar -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Dashboard</h1>
                </div>
                
                <div class="header-right">
                    <div class="header-stats">
                        <span class="stat-item">
                            <i class="fas fa-eye"></i>
                            <?php echo number_format($propertyStats['total_views']); ?> total views
                        </span>
                        <span class="stat-item">
                            <i class="fas fa-envelope"></i>
                            <?php echo count($recentInquiries); ?> inquiries
                        </span>
                    </div>
                    
                    <div class="header-actions">
                        <a href="add-property.php" class="btn-primary">
                            <i class="fas fa-plus"></i> Add Property
                        </a>
                        <a href="../sales.php" class="btn-secondary" target="_blank">
                            <i class="fas fa-external-link-alt"></i> View Site
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <div class="admin-content">
                <?php if (isset($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Statistics Overview -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-home"></i>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['total_properties']); ?></h3>
                            <p>Total Properties</p>
                        </div>
                    </div>
                    
                    <div class="stat-card success">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['available_properties']); ?></h3>
                            <p>Available Properties</p>
                        </div>
                    </div>
                    
                    <div class="stat-card danger">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['sold_properties']); ?></h3>
                            <p>Properties Sold</p>
                        </div>
                    </div>
                    
                    <div class="stat-card warning">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['total_inquiries']); ?></h3>
                            <p>Total Inquiries</p>
                        </div>
                    </div>
                    
                    <div class="stat-card info">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['total_views']); ?></h3>
                            <p>Total Views</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['featured_properties']); ?></h3>
                            <p>Featured Properties</p>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h3>Quick Actions</h3>
                    <div class="actions-grid">
                        <a href="add-property.php" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="action-content">
                                <h4>Add Property</h4>
                                <p>Add a new property listing</p>
                            </div>
                        </a>
                        
                        <a href="properties.php" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="action-content">
                                <h4>Manage Properties</h4>
                                <p>View and edit all properties</p>
                            </div>
                        </a>
                        
                        <a href="inquiries.php" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-envelope-open"></i>
                            </div>
                            <div class="action-content">
                                <h4>View Inquiries</h4>
                                <p>Manage customer inquiries</p>
                            </div>
                        </a>
                        
                        <a href="../sales.php" class="action-card" target="_blank">
                            <div class="action-icon">
                                <i class="fas fa-external-link-alt"></i>
                            </div>
                            <div class="action-content">
                                <h4>View Sales Page</h4>
                                <p>See the public sales page</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Activity Tables -->
                <div class="dashboard-tables">
                    <div class="table-section">
                        <div class="table-header">
                            <h3>Recent Inquiries</h3>
                            <a href="inquiries.php" class="btn-link">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Property</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recentInquiries)): ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty-state-mini">
                                                    <i class="fas fa-inbox"></i>
                                                    <p>No inquiries yet</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recentInquiries as $inquiry): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong><br>
                                                    <small><?php echo htmlspecialchars($inquiry['email']); ?></small>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($inquiry['property_title'] ?? 'General Inquiry'); ?>
                                                </td>
                                                <td>
                                                    <?php echo date('M j, Y', strtotime($inquiry['created_at'])); ?><br>
                                                    <small><?php echo date('g:i A', strtotime($inquiry['created_at'])); ?></small>
                                                </td>
                                                <td>
                                                    <span class="status-badge <?php echo $inquiry['status']; ?>">
                                                        <?php echo ucfirst($inquiry['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="table-actions">
                                                        <a href="inquiries.php?view=<?php echo $inquiry['id']; ?>" class="btn-action view">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="table-section">
                        <div class="table-header">
                            <h3>Recent Properties</h3>
                            <a href="properties.php" class="btn-link">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recentProperties)): ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty-state-mini">
                                                    <i class="fas fa-home"></i>
                                                    <p>No properties yet</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recentProperties as $property): ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($property['title']); ?></strong><br>
                                                    <small><?php echo htmlspecialchars($property['location']); ?></small>
                                                    <?php if ($property['featured']): ?>
                                                        <div class="featured-mini">
                                                            <i class="fas fa-star"></i> Featured
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong>TZS <?php echo number_format($property['price']); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="status-badge <?php echo $property['status']; ?>">
                                                        <?php echo ucfirst($property['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php echo date('M j, Y', strtotime($property['created_at'])); ?>
                                                </td>
                                                <td>
                                                    <div class="table-actions">
                                                        <a href="edit-property.php?id=<?php echo $property['id']; ?>" class="btn-action edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="../sales.php?property=<?php echo $property['id']; ?>" class="btn-action view" target="_blank">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
