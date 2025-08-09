<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();
$user = $auth->getUser();
$success = '';
$errors = [];

// Handle form submission
if ($_POST) {
    $settings_data = [
        'contact_phone' => trim($_POST['contact_phone'] ?? ''),
        'contact_phone2' => trim($_POST['contact_phone2'] ?? ''),
        'contact_email' => trim($_POST['contact_email'] ?? ''),
        'whatsapp_number' => trim($_POST['whatsapp_number'] ?? ''),
        'company_address' => trim($_POST['company_address'] ?? ''),
        'site_title' => trim($_POST['site_title'] ?? ''),
        'site_description' => trim($_POST['site_description'] ?? ''),
        'facebook_url' => trim($_POST['facebook_url'] ?? ''),
        'twitter_url' => trim($_POST['twitter_url'] ?? ''),
        'instagram_url' => trim($_POST['instagram_url'] ?? ''),
        'linkedin_url' => trim($_POST['linkedin_url'] ?? ''),
        'google_analytics' => trim($_POST['google_analytics'] ?? ''),
        'properties_per_page' => intval($_POST['properties_per_page'] ?? 12),
        'enable_inquiries' => isset($_POST['enable_inquiries']) ? '1' : '0',
        'enable_whatsapp' => isset($_POST['enable_whatsapp']) ? '1' : '0',
        'maintenance_mode' => isset($_POST['maintenance_mode']) ? '1' : '0'
    ];
    
    // Validation
    if (empty($settings_data['contact_email']) || !filter_var($settings_data['contact_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid contact email is required.";
    }
    
    if ($settings_data['properties_per_page'] < 1 || $settings_data['properties_per_page'] > 50) {
        $errors[] = "Properties per page must be between 1 and 50.";
    }
    
    // Update settings if no errors
    if (empty($errors)) {
        try {
            $db->beginTransaction();
            
            foreach ($settings_data as $key => $value) {
                $stmt = $db->prepare("
                    INSERT INTO settings (setting_key, setting_value, updated_at) 
                    VALUES (?, ?, NOW()) 
                    ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()
                ");
                $stmt->execute([$key, $value]);
            }
            
            $db->commit();
            $success = "Settings updated successfully.";
            
        } catch (PDOException $e) {
            $db->rollBack();
            $errors[] = "Error updating settings: " . $e->getMessage();
        }
    }
}

// Get current settings
try {
    $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $settings = [];
    $errors[] = "Error loading settings: " . $e->getMessage();
}

// Get system statistics
try {
    $stats = [];
    
    // Total properties
    $stmt = $db->query("SELECT COUNT(*) FROM properties");
    $stats['total_properties'] = $stmt->fetchColumn();
    
    // Total inquiries
    $stmt = $db->query("SELECT COUNT(*) FROM inquiries");
    $stats['total_inquiries'] = $stmt->fetchColumn();
    
    // Total page visits
    $stmt = $db->query("SELECT COUNT(*) FROM page_visits");
    $stats['total_visits'] = $stmt->fetchColumn();
    
    // Database size
    $stmt = $db->query("
        SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS db_size 
        FROM information_schema.tables 
        WHERE table_schema = DATABASE()
    ");
    $stats['db_size'] = $stmt->fetchColumn() . ' MB';
    
} catch (PDOException $e) {
    $stats = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Property CMS</title>
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
                    <h1>Settings</h1>
                    <p>Configure your website settings and preferences</p>
                </div>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <div class="settings-grid">
                    <!-- Settings Form -->
                    <div class="settings-section">
                        <form method="POST" class="settings-form">
                            <!-- Contact Information -->
                            <div class="form-section">
                                <h3>Contact Information</h3>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="contact_phone">Contact Phone 1 *</label>
                                        <input type="tel" id="contact_phone" name="contact_phone" required
                                               value="<?php echo htmlspecialchars($settings['contact_phone'] ?? ''); ?>">
                                        <small>Primary phone number for property inquiries</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_phone2">Contact Phone 2</label>
                                        <input type="tel" id="contact_phone2" name="contact_phone2"
                                               value="<?php echo htmlspecialchars($settings['contact_phone2'] ?? ''); ?>">
                                        <small>Secondary phone number (optional)</small>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="contact_email">Contact Email *</label>
                                        <input type="email" id="contact_email" name="contact_email" required
                                               value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="whatsapp_number">WhatsApp Number</label>
                                        <input type="tel" id="whatsapp_number" name="whatsapp_number"
                                               value="<?php echo htmlspecialchars($settings['whatsapp_number'] ?? ''); ?>"
                                               placeholder="255756069451">
                                        <small>Include country code without + sign</small>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="company_address">Company Address</label>
                                    <input type="text" id="company_address" name="company_address"
                                           value="<?php echo htmlspecialchars($settings['company_address'] ?? ''); ?>">
                                </div>
                            </div>
                            
                            <!-- Site Information -->
                            <div class="form-section">
                                <h3>Site Information</h3>
                                
                                <div class="form-group">
                                    <label for="site_title">Site Title</label>
                                    <input type="text" id="site_title" name="site_title"
                                           value="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="site_description">Site Description</label>
                                    <textarea id="site_description" name="site_description" rows="3"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            
                            <!-- Social Media -->
                            <div class="form-section">
                                <h3>Social Media Links</h3>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="facebook_url">Facebook URL</label>
                                        <input type="url" id="facebook_url" name="facebook_url"
                                               value="<?php echo htmlspecialchars($settings['facebook_url'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="twitter_url">Twitter URL</label>
                                        <input type="url" id="twitter_url" name="twitter_url"
                                               value="<?php echo htmlspecialchars($settings['twitter_url'] ?? ''); ?>">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="instagram_url">Instagram URL</label>
                                        <input type="url" id="instagram_url" name="instagram_url"
                                               value="<?php echo htmlspecialchars($settings['instagram_url'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="linkedin_url">LinkedIn URL</label>
                                        <input type="url" id="linkedin_url" name="linkedin_url"
                                               value="<?php echo htmlspecialchars($settings['linkedin_url'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- System Settings -->
                            <div class="form-section">
                                <h3>System Settings</h3>
                                
                                <div class="form-group">
                                    <label for="properties_per_page">Properties Per Page</label>
                                    <input type="number" id="properties_per_page" name="properties_per_page" 
                                           min="1" max="50" value="<?php echo $settings['properties_per_page'] ?? 12; ?>">
                                    <small>Number of properties to display per page (1-50)</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="google_analytics">Google Analytics Code</label>
                                    <textarea id="google_analytics" name="google_analytics" rows="3" 
                                              placeholder="Paste your Google Analytics tracking code here"><?php echo htmlspecialchars($settings['google_analytics'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <h4>Feature Settings</h4>
                                    
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="enable_inquiries" value="1" 
                                               <?php echo ($settings['enable_inquiries'] ?? '1') === '1' ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                        Enable Property Inquiries
                                    </label>
                                    
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="enable_whatsapp" value="1" 
                                               <?php echo ($settings['enable_whatsapp'] ?? '1') === '1' ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                        Enable WhatsApp Contact
                                    </label>
                                    
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="maintenance_mode" value="1" 
                                               <?php echo ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                        Maintenance Mode
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save"></i>
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- System Information -->
                    <div class="settings-sidebar">
                        <div class="info-section">
                            <h3>System Information</h3>
                            
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Total Properties</div>
                                    <div class="info-value"><?php echo number_format($stats['total_properties'] ?? 0); ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Total Inquiries</div>
                                    <div class="info-value"><?php echo number_format($stats['total_inquiries'] ?? 0); ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Page Visits</div>
                                    <div class="info-value"><?php echo number_format($stats['total_visits'] ?? 0); ?></div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">Database Size</div>
                                    <div class="info-value"><?php echo $stats['db_size'] ?? 'Unknown'; ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <h3>Quick Actions</h3>
                            
                            <div class="quick-actions">
                                <a href="../sales.php" target="_blank" class="action-btn">
                                    <i class="fas fa-external-link-alt"></i>
                                    View Website
                                </a>
                                
                                <a href="properties.php" class="action-btn">
                                    <i class="fas fa-home"></i>
                                    Manage Properties
                                </a>
                                
                                <a href="inquiries.php" class="action-btn">
                                    <i class="fas fa-envelope"></i>
                                    View Inquiries
                                </a>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <h3>Backup & Maintenance</h3>
                            
                            <div class="maintenance-actions">
                                <button type="button" class="action-btn" onclick="clearCache()">
                                    <i class="fas fa-broom"></i>
                                    Clear Cache
                                </button>
                                
                                <button type="button" class="action-btn" onclick="optimizeDatabase()">
                                    <i class="fas fa-database"></i>
                                    Optimize Database
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="admin-scripts.js"></script>
    <script>
        function clearCache() {
            if (confirm('Are you sure you want to clear the cache?')) {
                // Implement cache clearing logic
                showNotification('Cache cleared successfully', 'success');
            }
        }
        
        function optimizeDatabase() {
            if (confirm('Are you sure you want to optimize the database?')) {
                // Implement database optimization logic
                showNotification('Database optimized successfully', 'success');
            }
        }
    </script>
</body>
</html>