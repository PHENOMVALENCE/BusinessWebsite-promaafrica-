<?php
require_once 'config/database.php';

// Get database connection
$db = Database::getInstance();
$pdo = $db->getConnection();

// Mobile device detection function
function isMobileDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone', 'BlackBerry'];
    
    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }
    return false;
}

// Track page visit with mobile detection
$isMobile = isMobileDevice();
$db->trackVisit('sales_page', ['is_mobile' => $isMobile]);

// Get filters from URL with mobile-friendly defaults
$search = trim($_GET['search'] ?? '');
$property_type = $_GET['property_type'] ?? '';
$location = $_GET['location'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$sort = $_GET['sort'] ?? 'featured';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = $isMobile ? 6 : 12;

// Handle property view
$view_property = null;
if (isset($_GET['view']) && is_numeric($_GET['view'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE id = ? AND status = 'available'");
        $stmt->execute([$_GET['view']]);
        $view_property = $stmt->fetch();
        
        if ($view_property) {
            $update_views = $pdo->prepare("UPDATE properties SET views = COALESCE(views, 0) + 1 WHERE id = ?");
            $update_views->execute([$_GET['view']]);
        }
    } catch(PDOException $e) {
        error_log("Error fetching property: " . $e->getMessage());
    }
}

try {
    // Build query conditions
    $conditions = ["status = 'available'"];
    $params = [];
    
    if (!empty($search)) {
        $conditions[] = "(title LIKE ? OR description LIKE ? OR location LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    if (!empty($property_type)) {
        $conditions[] = "property_type = ?";
        $params[] = $property_type;
    }
    
    if (!empty($location)) {
        $conditions[] = "location LIKE ?";
        $params[] = "%$location%";
    }
    
    if (!empty($min_price)) {
        $conditions[] = "price >= ?";
        $params[] = $min_price;
    }
    
    if (!empty($max_price)) {
        $conditions[] = "price <= ?";
        $params[] = $max_price;
    }
    
    $where_clause = implode(' AND ', $conditions);
    
    // Determine sort order
    $order_by = "featured DESC, created_at DESC";
    switch ($sort) {
        case 'newest':
            $order_by = "created_at DESC";
            break;
        case 'price_low':
            $order_by = "price ASC";
            break;
        case 'price_high':
            $order_by = "price DESC";
            break;
        case 'location':
            $order_by = "location ASC";
            break;
    }
    
    // Get total count for pagination
    $count_sql = "SELECT COUNT(*) FROM properties WHERE $where_clause";
    $count_stmt = $pdo->prepare($count_sql);
    $count_stmt->execute($params);
    $total_properties = $count_stmt->fetchColumn();
    $total_pages = ceil($total_properties / $per_page);
    
    // Get properties for current page
    $offset = ($page - 1) * $per_page;
    $sql = "SELECT * FROM properties WHERE $where_clause ORDER BY $order_by LIMIT $per_page OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $properties = $stmt->fetchAll();
    
    // Get unique locations and types for filters
    $locations_stmt = $pdo->query("SELECT DISTINCT location FROM properties WHERE status = 'available' ORDER BY location");
    $locations = $locations_stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $types_stmt = $pdo->query("SELECT DISTINCT property_type FROM properties WHERE status = 'available' ORDER BY property_type");
    $types = $types_stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Get settings
    $settings_stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settings = $settings_stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
} catch(PDOException $e) {
    $properties = [];
    $locations = [];
    $types = [];
    $total_properties = 0;
    $total_pages = 0;
    $settings = [];
    error_log("Database error in sales.php: " . $e->getMessage());
}

// Generate responsive image URLs
function getResponsiveImageUrl($imagePath, $size = 'medium') {
    if (empty($imagePath)) {
        return "https://via.placeholder.com/400x250/f6ae01/000000?text=Property+Image";
    }
    
    if (file_exists("uploads/properties/" . $imagePath)) {
        return "uploads/properties/" . htmlspecialchars($imagePath);
    }
    
    return "https://via.placeholder.com/400x250/f6ae01/000000?text=Property+Image";
}

// Format price with currency
function formatPrice($price, $currency = 'TZS', $mobile = false) {
    $symbol = $currency === '$' ? '$' : 'TZS ';
    
    if ($mobile) {
        if ($price >= 1000000000) {
            return $symbol . number_format($price / 1000000000, 1) . 'B';
        } elseif ($price >= 1000000) {
            return $symbol . number_format($price / 1000000, 1) . 'M';
        } elseif ($price >= 1000) {
            return $symbol . number_format($price / 1000, 0) . 'K';
        }
    }
    
    return $symbol . number_format($price);
}

// Get display phone number
function getDisplayPhone($property, $settings) {
    if ($property['phone_display'] === 'phone2' && !empty($settings['contact_phone2'])) {
        return $settings['contact_phone2'];
    }
    return $settings['contact_phone'] ?? '+255756069451';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Discover premium properties for sale in Tanzania with Proma Africa. Professional guidance and transparent pricing.">
    <meta name="keywords" content="Property Sales Tanzania, Real Estate Tanzania, Houses for Sale, Apartments Tanzania">
    <meta name="format-detection" content="telephone=yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#f6ae01">
    <title><?php echo $view_property ? htmlspecialchars($view_property['title']) . ' - ' : ''; ?>Premium Properties for Sale - Proma Africa</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sales-styles.css">
    
    <?php if ($view_property): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateListing",
        "name": "<?php echo htmlspecialchars($view_property['title']); ?>",
        "description": "<?php echo htmlspecialchars($view_property['description']); ?>",
        "price": "<?php echo $view_property['price']; ?>",
        "priceCurrency": "<?php echo $view_property['currency'] === '$' ? 'USD' : 'TZS'; ?>",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "<?php echo htmlspecialchars($view_property['location']); ?>",
            "addressCountry": "TZ"
        }
    }
    </script>
    <?php endif; ?>
    <style>
        /* Apply Gill Sans MT globally */


    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <img src="2.png" alt="Proma Africa Logo">
                <div class="logo-text">
                    <h1>Proma Africa</h1>
                </div>
            </a>
            
            <div class="hamburger-menu">
                <button class="menu-icon" id="mobileMenuToggle" aria-label="Toggle mobile menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="menu-links" id="navLinks">
                    <a href="index.php">Home</a>
                    <a href="about.php">About</a>
                    <a href="services.php">Services</a>
                    <a href="sales.php" class="active">Properties</a>
                    <a href="news.php">News</a>
                    <a href="contact.php">Contact</a>
                    <a href="tel:<?php echo getDisplayPhone($view_property ?? [], $settings); ?>" class="nav-cta">
                        <i class="fas fa-phone"></i> Call Now
                    </a>
                    <a href="#" class="close-btn" id="closeBtn"><i class="fas fa-times"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <?php if ($view_property): ?>
        <!-- Single Property View -->
        <section class="property-detail">
            <div class="container">
                <div class="breadcrumb">
                    <a href="sales.php"><i class="fas fa-arrow-left"></i> Back to Properties</a>
                </div>
                
                <div class="property-detail-grid">
                    <!-- Property Images -->
                    <div class="property-images-section">
                        <?php 
                        $images = json_decode($view_property['images'], true);
                        if (is_array($images) && !empty($images)): 
                        ?>
                            <div class="main-image-container">
                                <img id="mainImage" src="<?php echo getResponsiveImageUrl($images[0]); ?>" 
                                     alt="<?php echo htmlspecialchars($view_property['title']); ?>"
                                     loading="eager">
                                
                                <?php if ($view_property['featured']): ?>
                                    <div class="featured-badge">
                                        <i class="fas fa-star"></i> Featured
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (count($images) > 1): ?>
                                <div class="image-thumbnails">
                                    <?php foreach ($images as $index => $image): ?>
                                        <img src="<?php echo getResponsiveImageUrl($image); ?>" 
                                             alt="Property Image <?php echo $index + 1; ?>"
                                             onclick="changeMainImage('<?php echo getResponsiveImageUrl($image); ?>')"
                                             class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>"
                                             loading="lazy">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="main-image-container">
                                <div class="no-image">
                                    <i class="fas fa-home"></i>
                                    <p>No Image Available</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Property Information -->
                    <div class="property-info-section">
                        <div class="property-header">
                            <h1><?php echo htmlspecialchars($view_property['title']); ?></h1>
                            <div class="property-price">
                                <?php echo formatPrice($view_property['price'], $view_property['currency'] ?? 'TZS', $isMobile); ?>
                            </div>
                        </div>
                        
                        <div class="property-meta">
                            <div class="meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($view_property['location']); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-building"></i>
                                <span><?php echo ucfirst(htmlspecialchars($view_property['property_type'])); ?></span>
                            </div>
                            <?php if ($view_property['area'] > 0): ?>
                                <div class="meta-item">
                                    <i class="fas fa-ruler-combined"></i>
                                    <span><?php echo number_format($view_property['area']); ?> m²</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($view_property['bedrooms'] > 0 || $view_property['bathrooms'] > 0): ?>
                            <div class="property-features">
                                <?php if ($view_property['bedrooms'] > 0): ?>
                                    <div class="feature">
                                        <i class="fas fa-bed"></i>
                                        <span><?php echo $view_property['bedrooms']; ?> Bedroom<?php echo $view_property['bedrooms'] > 1 ? 's' : ''; ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($view_property['bathrooms'] > 0): ?>
                                    <div class="feature">
                                        <i class="fas fa-bath"></i>
                                        <span><?php echo $view_property['bathrooms']; ?> Bathroom<?php echo $view_property['bathrooms'] > 1 ? 's' : ''; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Additional Features -->
                        <?php 
                        $additional_features = [];
                        if ($view_property['dining']) $additional_features[] = ['icon' => 'fas fa-utensils', 'text' => 'Dining Room'];
                        if ($view_property['sitting_room']) $additional_features[] = ['icon' => 'fas fa-couch', 'text' => 'Sitting Room'];
                        if ($view_property['garden']) $additional_features[] = ['icon' => 'fas fa-seedling', 'text' => 'Garden'];
                        if ($view_property['balcony']) $additional_features[] = ['icon' => 'fas fa-building', 'text' => 'Balcony'];
                        if ($view_property['lift']) $additional_features[] = ['icon' => 'fas fa-elevator', 'text' => 'Lift/Elevator'];
                        if ($view_property['garage']) $additional_features[] = ['icon' => 'fas fa-car', 'text' => 'Garage'];
                        
                        if (!empty($additional_features)): ?>
                            <div class="additional-features">
                                <h3>Additional Features</h3>
                                <div class="features-grid">
                                    <?php foreach ($additional_features as $feature): ?>
                                        <div class="feature-item">
                                            <i class="<?php echo $feature['icon']; ?>"></i>
                                            <span><?php echo $feature['text']; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($view_property['description'])): ?>
                            <div class="property-description">
                                <h3>Description</h3>
                                <p><?php echo nl2br(htmlspecialchars($view_property['description'])); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="contact-actions">
                            <a href="https://wa.me/<?php echo $settings['whatsapp_number'] ?? '255756069451'; ?>?text=Hi%2C%20I%27m%20interested%20in%20<?php echo urlencode($view_property['title']); ?>" 
                               class="btn-contact btn-whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                            
                            <a href="tel:<?php echo getDisplayPhone($view_property, $settings); ?>" 
                               class="btn-contact btn-call">
                                <i class="fas fa-phone"></i>
                                Call Now
                            </a>
                            
                            <button onclick="openInquiryModal(<?php echo $view_property['id']; ?>, '<?php echo addslashes($view_property['title']); ?>')" 
                                    class="btn-contact btn-inquire">
                                <i class="fas fa-envelope"></i>
                                Send Inquiry
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-background" style="background-image: url('b7.jpg');"></div>
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-award"></i>
                    <span>Tanzania's Premier Real Estate</span>
                </div>
                
                <h1>Discover Your Dream Property in Tanzania Mainland &<span class="highlight"> Zanzibar</span></h1>
                <p>Explore our curated selection of premium properties with professional guidance and transparent pricing.</p>
                
                <div class="hero-buttons">
                    <a href="#properties" class="btn-hero btn-primary">
                        <i class="fas fa-search"></i>
                        Explore Properties
                    </a>
                    <a href="contact.php" class="btn-hero btn-secondary">
                        <i class="fas fa-phone"></i>
                        Contact Expert
                    </a>
                </div>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo max(count($properties), 8); ?>+</div>
                        <div class="stat-label">Properties</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo max(count($locations), 8); ?>+</div>
                        <div class="stat-label">Locations</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Happy Clients</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search Filters -->
        <section class="filters-section" id="properties">
            <div class="container">
                <div class="filters-header">
                    <h2>Find Your Perfect Property</h2>
                </div>
                
                <form method="GET" class="filters-form">
                    <div class="filter-row">
                        <div class="filter-group">
                            <input type="text" name="search" placeholder="Search properties..." 
                                   value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <select name="property_type">
                                <option value="">All Types</option>
                                <?php foreach ($types as $type): ?>
                                    <option value="<?php echo htmlspecialchars($type); ?>" 
                                            <?php echo $property_type === $type ? 'selected' : ''; ?>>
                                        <?php echo ucfirst(htmlspecialchars($type)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <select name="location">
                                <option value="">All Locations</option>
                                <?php foreach ($locations as $loc): ?>
                                    <option value="<?php echo htmlspecialchars($loc); ?>"
                                            <?php echo $location === $loc ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($loc); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <input type="number" name="min_price" placeholder="Min Price" 
                                   value="<?php echo htmlspecialchars($min_price); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <input type="number" name="max_price" placeholder="Max Price" 
                                   value="<?php echo htmlspecialchars($max_price); ?>">
                        </div>
                        
                        <div class="filter-group">
                            <select name="sort">
                                <option value="featured" <?php echo $sort === 'featured' ? 'selected' : ''; ?>>Featured First</option>
                                <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                                <option value="price_low" <?php echo $sort === 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                                <option value="price_high" <?php echo $sort === 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search"></i>
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Properties Section -->
        <section class="properties-section">
            <div class="container">
                <div class="properties-header">
                    <h2>Available Properties (<?php echo number_format($total_properties); ?>)</h2>
                </div>

                <?php if (empty($properties)): ?>
                    <div class="empty-state">
                        <i class="fas fa-home"></i>
                        <h3>No Properties Found</h3>
                        <p>Try adjusting your search criteria to find more properties.</p>
                        <a href="sales.php" class="btn-primary">View All Properties</a>
                    </div>
                <?php else: ?>
                    <div class="properties-grid" id="propertiesGrid">
                        <?php foreach ($properties as $property): ?>
                            <div class="property-card" data-property-id="<?php echo $property['id']; ?>">
                                <div class="property-image">
                                    <?php 
                                    $images = json_decode($property['images'], true);
                                    $firstImage = is_array($images) && !empty($images) ? $images[0] : null;
                                    ?>
                                    
                                    <img src="<?php echo getResponsiveImageUrl($firstImage); ?>" 
                                         alt="<?php echo htmlspecialchars($property['title']); ?>"
                                         loading="lazy">
                                    
                                    <?php if ($property['featured']): ?>
                                        <div class="featured-badge">
                                            <i class="fas fa-star"></i>
                                            Featured
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="property-price">
                                        <?php echo formatPrice($property['price'], $property['currency'] ?? 'TZS', $isMobile); ?>
                                    </div>
                                    
                                    <button class="favorite-btn" aria-label="Add to favorites">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                                
                                <div class="property-content">
                                    <h3 class="property-title">
                                        <?php echo htmlspecialchars($property['title']); ?>
                                    </h3>
                                    
                                    <div class="property-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($property['location']); ?>
                                    </div>
                                    
                                    <?php if ($property['bedrooms'] > 0 || $property['bathrooms'] > 0 || $property['area'] > 0): ?>
                                        <div class="property-features">
                                            <?php if ($property['bedrooms'] > 0): ?>
                                                <span><i class="fas fa-bed"></i> <?php echo $property['bedrooms']; ?></span>
                                            <?php endif; ?>
                                            
                                            <?php if ($property['bathrooms'] > 0): ?>
                                                <span><i class="fas fa-bath"></i> <?php echo $property['bathrooms']; ?></span>
                                            <?php endif; ?>
                                            
                                            <?php if ($property['area'] > 0): ?>
                                                <span><i class="fas fa-ruler-combined"></i> <?php echo number_format($property['area']); ?> m²</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Additional Features Icons -->
                                    <?php 
                                    $features = [];
                                    if ($property['dining']) $features[] = ['icon' => 'fas fa-utensils', 'title' => 'Dining Room'];
                                    if ($property['sitting_room']) $features[] = ['icon' => 'fas fa-couch', 'title' => 'Sitting Room'];
                                    if ($property['garden']) $features[] = ['icon' => 'fas fa-seedling', 'title' => 'Garden'];
                                    if ($property['balcony']) $features[] = ['icon' => 'fas fa-building', 'title' => 'Balcony'];
                                    if ($property['lift']) $features[] = ['icon' => 'fas fa-elevator', 'title' => 'Lift'];
                                    if ($property['garage']) $features[] = ['icon' => 'fas fa-car', 'title' => 'Garage'];
                                    
                                    if (!empty($features)): ?>
                                        <div class="property-amenities">
                                            <?php foreach (array_slice($features, 0, 4) as $feature): ?>
                                                <span class="amenity-icon" title="<?php echo $feature['title']; ?>">
                                                    <i class="<?php echo $feature['icon']; ?>"></i>
                                                </span>
                                            <?php endforeach; ?>
                                            <?php if (count($features) > 4): ?>
                                                <span class="more-amenities">+<?php echo count($features) - 4; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="property-actions">
                                        <a href="sales.php?view=<?php echo $property['id']; ?>" class="btn-view">
                                            View Details
                                        </a>
                                        
                                        <a href="https://wa.me/<?php echo $settings['whatsapp_number'] ?? '255756069451'; ?>?text=Hi%2C%20I%27m%20interested%20in%20<?php echo urlencode($property['title']); ?>" 
                                           class="btn-whatsapp" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Quick Contact Bar (Mobile Only) -->
    <?php if ($isMobile): ?>
    <div class="quick-contact-bar">
        <a href="tel:<?php echo getDisplayPhone($view_property ?? [], $settings); ?>" class="quick-contact-btn">
            <i class="fas fa-phone"></i>
            <span>Call</span>
        </a>
        <a href="https://wa.me/<?php echo $settings['whatsapp_number'] ?? '255756069451'; ?>" class="quick-contact-btn">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <button class="quick-contact-btn" onclick="openInquiryModal()">
            <i class="fas fa-envelope"></i>
            <span>Inquire</span>
        </button>
    </div>
    <?php endif; ?>

    <!-- Inquiry Modal -->
    <div id="inquiryModal" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>Property Inquiry</h3>
                <button class="modal-close" onclick="closeInquiryModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="inquiryForm" method="POST" action="admin/submit-inquiry.php">
                <input type="hidden" id="propertyId" name="property_id">
                
                <div class="form-group">
                    <label for="inquiryName">Full Name *</label>
                    <input type="text" id="inquiryName" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="inquiryEmail">Email Address *</label>
                    <input type="email" id="inquiryEmail" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="inquiryPhone">Phone Number</label>
                    <input type="tel" id="inquiryPhone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="inquiryMessage">Message *</label>
                    <textarea id="inquiryMessage" name="message" rows="4" required></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" onclick="closeInquiryModal()" class="btn-cancel">Cancel</button>
                    <button type="submit" class="btn-submit">Send Inquiry</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Proma Africa</h3>
                    <p>Your trusted partner in property survey and real estate services across Tanzania.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="sales.php">Properties</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-phone"></i> <?php echo $settings['contact_phone'] ?? '+255 756 069 451'; ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo $settings['contact_email'] ?? 'info@promaafrica.com'; ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $settings['company_address'] ?? 'Dar es Salaam, Tanzania'; ?></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Proma Africa. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="sales-scripts.js"></script>
    <script>
        function changeMainImage(src) {
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = src;
                document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
                event.target.classList.add('active');
            }
        }
        
        function openInquiryModal(propertyId, propertyTitle) {
            document.getElementById('propertyId').value = propertyId || '';
            document.getElementById('inquiryMessage').value = propertyTitle ? `Hi, I'm interested in the property: ${propertyTitle}. Could you provide more details?` : '';
            document.getElementById('inquiryModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeInquiryModal() {
            document.getElementById('inquiryModal').style.display = 'none';
            document.body.style.overflow = '';
        }
        
        document.querySelector('.modal-overlay').addEventListener('click', closeInquiryModal);
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && document.getElementById('inquiryModal').style.display === 'flex') {
                closeInquiryModal();
            }
        });

        // Hamburger menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navLinks = document.getElementById('navLinks');
        const closeBtn = document.getElementById('closeBtn');

        mobileMenuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('show');
            mobileMenuToggle.classList.toggle('active');
            document.body.style.overflow = navLinks.classList.contains('show') ? 'hidden' : '';
        });

        closeBtn.addEventListener('click', () => {
            navLinks.classList.remove('show');
            mobileMenuToggle.classList.remove('active');
            document.body.style.overflow = '';
        });

        document.addEventListener('click', (event) => {
            if (!mobileMenuToggle.contains(event.target) && !navLinks.contains(event.target) && navLinks.classList.contains('show')) {
                navLinks.classList.remove('show');
                mobileMenuToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
</body>
</html>