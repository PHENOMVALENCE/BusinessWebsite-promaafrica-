<?php
session_start();
require_once '../database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

try {
    $pdo = getConnection();
    
    // Get date range from query parameters
    $dateRange = $_GET['range'] ?? '30';
    $startDate = date('Y-m-d', strtotime("-{$dateRange} days"));
    $endDate = date('Y-m-d');
    
    // Property statistics
    $stmt = $pdo->query("SELECT 
        COUNT(*) as total_properties,
        SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available_properties,
        SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_properties,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_properties,
        SUM(CASE WHEN featured = 1 THEN 1 ELSE 0 END) as featured_properties,
        SUM(views) as total_views,
        SUM(inquiries) as total_inquiries,
        AVG(price) as avg_price
        FROM properties");
    $propertyStats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Monthly property additions
    $stmt = $pdo->query("SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        COUNT(*) as count
        FROM properties 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month");
    $monthlyProperties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Property views by month
    $stmt = $pdo->query("SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        SUM(views) as total_views
        FROM properties 
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month");
    $monthlyViews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Top performing properties
    $stmt = $pdo->query("SELECT 
        id, title, location, views, inquiries, price, status
        FROM properties 
        ORDER BY (views + inquiries * 2) DESC 
        LIMIT 10");
    $topProperties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Property types distribution
    $stmt = $pdo->query("SELECT 
        type, COUNT(*) as count
        FROM properties 
        GROUP BY type
        ORDER BY count DESC");
    $propertyTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Location distribution
    $stmt = $pdo->query("SELECT 
        location, COUNT(*) as count, AVG(price) as avg_price
        FROM properties 
        GROUP BY location
        ORDER BY count DESC
        LIMIT 10");
    $locationStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Recent inquiries
    $stmt = $pdo->query("SELECT 
        pi.*, p.title as property_title
        FROM property_inquiries pi
        LEFT JOIN properties p ON pi.property_id = p.id
        ORDER BY pi.created_at DESC
        LIMIT 10");
    $recentInquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Analytics data (if analytics table exists)
    $analyticsData = [];
    try {
        $stmt = $pdo->query("SELECT 
            event_type, 
            COUNT(*) as count,
            DATE(created_at) as date
            FROM analytics 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL {$dateRange} DAY)
            GROUP BY event_type, DATE(created_at)
            ORDER BY date DESC");
        $analyticsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        // Analytics table might not exist
    }
    
} catch(PDOException $e) {
    $error = "Error loading analytics: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Proma Africa Admin</title>
    <link rel="stylesheet" href="admin-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <img src="../2.png" alt="Proma Africa" class="sidebar-logo">
                    <div class="brand-text">
                        <h3>Proma Africa</h3>
                        <span>Admin Panel</span>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="properties.php" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Properties</span>
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
                        </a>
                    </li>
                    
                    <li class="nav-item active">
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
                <a href="logout.php" class="logout-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Bar -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h1>Analytics Dashboard</h1>
                        <p>Track your property performance and user engagement</p>
                    </div>
                </div>
                
                <div class="header-right">
                    <div class="header-actions">
                        <select id="dateRange" class="filter-select" onchange="updateDateRange()">
                            <option value="7" <?php echo $dateRange == '7' ? 'selected' : ''; ?>>Last 7 days</option>
                            <option value="30" <?php echo $dateRange == '30' ? 'selected' : ''; ?>>Last 30 days</option>
                            <option value="90" <?php echo $dateRange == '90' ? 'selected' : ''; ?>>Last 90 days</option>
                            <option value="365" <?php echo $dateRange == '365' ? 'selected' : ''; ?>>Last year</option>
                        </select>
                        
                        <button class="btn-primary" onclick="exportReport()">
                            <i class="fas fa-download"></i>
                            <span>Export Report</span>
                        </button>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <div class="admin-content">
                <!-- Overview Stats -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['total_properties']); ?></h3>
                            <p>Total Properties</p>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>+12% from last month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['total_views']); ?></h3>
                            <p>Total Views</p>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>+25% from last month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card info">
                        <div class="stat-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($propertyStats['total_inquiries']); ?></h3>
                            <p>Total Inquiries</p>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>+18% from last month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-content">
                            <h3>$<?php echo number_format($propertyStats['avg_price']); ?></h3>
                            <p>Average Price</p>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i>
                                <span>+8% from last month</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Section -->
                <div class="charts-grid">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Property Additions Over Time</h3>
                            <p>Monthly property listings added</p>
                        </div>
                        <div class="chart-container">
                            <canvas id="propertyChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Property Views Trend</h3>
                            <p>Monthly property views</p>
                        </div>
                        <div class="chart-container">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Property Types Distribution</h3>
                            <p>Breakdown by property type</p>
                        </div>
                        <div class="chart-container">
                            <canvas id="typesChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Property Status</h3>
                            <p>Current status distribution</p>
                        </div>
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Tables Section -->
                <div class="tables-grid">
                    <!-- Top Performing Properties -->
                    <div class="table-card">
                        <div class="table-header">
                            <h3>Top Performing Properties</h3>
                            <p>Based on views and inquiries</p>
                        </div>
                        <div class="table-container">
                            <table class="analytics-table">
                                <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Location</th>
                                        <th>Views</th>
                                        <th>Inquiries</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topProperties as $property): ?>
                                        <tr>
                                            <td>
                                                <div class="property-info">
                                                    <strong><?php echo htmlspecialchars($property['title']); ?></strong>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($property['location']); ?></td>
                                            <td>
                                                <span class="metric-value"><?php echo number_format($property['views']); ?></span>
                                            </td>
                                            <td>
                                                <span class="metric-value"><?php echo number_format($property['inquiries']); ?></span>
                                            </td>
                                            <td>
                                                <span class="price-value">$<?php echo number_format($property['price']); ?></span>
                                            </td>
                                            <td>
                                                <span class="status-badge status-<?php echo $property['status']; ?>">
                                                    <?php echo ucfirst($property['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Location Performance -->
                    <div class="table-card">
                        <div class="table-header">
                            <h3>Location Performance</h3>
                            <p>Properties and average prices by location</p>
                        </div>
                        <div class="table-container">
                            <table class="analytics-table">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Properties</th>
                                        <th>Avg. Price</th>
                                        <th>Market Share</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($locationStats as $location): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($location['location']); ?></strong>
                                            </td>
                                            <td>
                                                <span class="metric-value"><?php echo number_format($location['count']); ?></span>
                                            </td>
                                            <td>
                                                <span class="price-value">$<?php echo number_format($location['avg_price']); ?></span>
                                            </td>
                                            <td>
                                                <div class="progress-bar">
                                                    <div class="progress-fill" style="width: <?php echo ($location['count'] / $propertyStats['total_properties']) * 100; ?>%"></div>
                                                    <span class="progress-text"><?php echo round(($location['count'] / $propertyStats['total_properties']) * 100, 1); ?>%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Recent Inquiries -->
                    <div class="table-card full-width">
                        <div class="table-header">
                            <h3>Recent Inquiries</h3>
                            <p>Latest property inquiries from potential buyers</p>
                        </div>
                        <div class="table-container">
                            <table class="analytics-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Property</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentInquiries as $inquiry): ?>
                                        <tr>
                                            <td>
                                                <span class="date-value"><?php echo date('M j, Y', strtotime($inquiry['created_at'])); ?></span>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong>
                                            </td>
                                            <td>
                                                <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" class="email-link">
                                                    <?php echo htmlspecialchars($inquiry['email']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="tel:<?php echo htmlspecialchars($inquiry['phone']); ?>" class="phone-link">
                                                    <?php echo htmlspecialchars($inquiry['phone']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="property-title"><?php echo htmlspecialchars($inquiry['property_title']); ?></span>
                                            </td>
                                            <td>
                                                <div class="message-preview">
                                                    <?php echo htmlspecialchars(substr($inquiry['message'], 0, 50)) . (strlen($inquiry['message']) > 50 ? '...' : ''); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" class="action-btn reply" title="Reply">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    <a href="tel:<?php echo htmlspecialchars($inquiry['phone']); ?>" class="action-btn call" title="Call">
                                                        <i class="fas fa-phone"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Chart.js configurations
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#cccccc'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#999999'
                    },
                    grid: {
                        color: '#333333'
                    }
                },
                y: {
                    ticks: {
                        color: '#999999'
                    },
                    grid: {
                        color: '#333333'
                    }
                }
            }
        };
        
        // Property additions chart
        const propertyCtx = document.getElementById('propertyChart').getContext('2d');
        new Chart(propertyCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($monthlyProperties, 'month')); ?>,
                datasets: [{
                    label: 'Properties Added',
                    data: <?php echo json_encode(array_column($monthlyProperties, 'count')); ?>,
                    borderColor: '#f6ae01',
                    backgroundColor: 'rgba(246, 174, 1, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: chartOptions
        });
        
        // Views chart
        const viewsCtx = document.getElementById('viewsChart').getContext('2d');
        new Chart(viewsCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($monthlyViews, 'month')); ?>,
                datasets: [{
                    label: 'Total Views',
                    data: <?php echo json_encode(array_column($monthlyViews, 'total_views')); ?>,
                    backgroundColor: 'rgba(246, 174, 1, 0.8)',
                    borderColor: '#f6ae01',
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });
        
        // Property types chart
        const typesCtx = document.getElementById('typesChart').getContext('2d');
        new Chart(typesCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($propertyTypes, 'type')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($propertyTypes, 'count')); ?>,
                    backgroundColor: [
                        '#f6ae01',
                        '#28a745',
                        '#17a2b8',
                        '#ffc107',
                        '#dc3545',
                        '#6c757d'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#cccccc'
                        }
                    }
                }
            }
        });
        
        // Status chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Available', 'Sold', 'Pending'],
                datasets: [{
                    data: [
                        <?php echo $propertyStats['available_properties']; ?>,
                        <?php echo $propertyStats['sold_properties']; ?>,
                        <?php echo $propertyStats['pending_properties']; ?>
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#ffc107'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#cccccc'
                        }
                    }
                }
            }
        });
        
        // Functions
        function updateDateRange() {
            const range = document.getElementById('dateRange').value;
            window.location.href = `analytics.php?range=${range}`;
        }
        
        function exportReport() {
            // Implement export functionality
            alert('Export functionality would be implemented here');
        }
    </script>
</body>
</html>
