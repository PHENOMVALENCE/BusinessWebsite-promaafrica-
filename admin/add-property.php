<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

$property = null;
$is_edit = false;

// Check if editing
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $is_edit = true;
    try {
        $stmt = $db->prepare("SELECT * FROM properties WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $property = $stmt->fetch();
        
        if (!$property) {
            header('Location: properties.php');
            exit;
        }
    } catch (PDOException $e) {
        $error = "Error fetching property: " . $e->getMessage();
    }
}

// Get settings for phone numbers
try {
    $settings_stmt = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('contact_phone', 'contact_phone2')");
    $settings = $settings_stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $settings = [];
}

// Handle form submission
if ($_POST) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $property_type = $_POST['property_type'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $currency = $_POST['currency'] ?? 'TZS';
    $phone_display = $_POST['phone_display'] ?? 'phone1';
    $bedrooms = intval($_POST['bedrooms'] ?? 0);
    $bathrooms = intval($_POST['bathrooms'] ?? 0);
    $area = floatval($_POST['area'] ?? 0);
    $featured = isset($_POST['featured']) ? 1 : 0;
    $status = $_POST['status'] ?? 'available';
    
    // New amenity fields
    $dining = isset($_POST['dining']) ? 1 : 0;
    $sitting_room = isset($_POST['sitting_room']) ? 1 : 0;
    $garden = isset($_POST['garden']) ? 1 : 0;
    $balcony = isset($_POST['balcony']) ? 1 : 0;
    $lift = isset($_POST['lift']) ? 1 : 0;
    $garage = isset($_POST['garage']) ? 1 : 0;
    
    // Validation
    $errors = [];
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($property_type)) $errors[] = "Property type is required.";
    if (empty($location)) $errors[] = "Location is required.";
    if ($price <= 0) $errors[] = "Price must be greater than 0.";
    
    // Handle image uploads
    $uploaded_images = [];
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $upload_dir = '../uploads/properties/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        foreach ($_FILES['images']['name'] as $key => $filename) {
            if (!empty($filename)) {
                $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($file_extension, $allowed_extensions)) {
                    $file_size = $_FILES['images']['size'][$key];
                    if ($file_size > 5 * 1024 * 1024) { // 5MB limit
                        $errors[] = "File too large: $filename (max 5MB)";
                        continue;
                    }
                    
                    $new_filename = uniqid() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $upload_path)) {
                        $uploaded_images[] = $new_filename;
                    } else {
                        $errors[] = "Failed to upload: $filename";
                    }
                } else {
                    $errors[] = "Invalid file type for: $filename";
                }
            }
        }
    }
    
    if (empty($errors)) {
        try {
            if ($is_edit) {
                // Update existing property
                $images_json = !empty($uploaded_images) ? json_encode($uploaded_images) : $property['images'];
                
                $stmt = $db->prepare("
                    UPDATE properties SET 
                    title = ?, description = ?, property_type = ?, location = ?, 
                    price = ?, currency = ?, phone_display = ?, bedrooms = ?, bathrooms = ?, area = ?, 
                    featured = ?, status = ?, images = ?, 
                    dining = ?, sitting_room = ?, garden = ?, balcony = ?, lift = ?, garage = ?,
                    updated_at = NOW()
                    WHERE id = ?
                ");
                
                $stmt->execute([
                    $title, $description, $property_type, $location,
                    $price, $currency, $phone_display, $bedrooms, $bathrooms, $area,
                    $featured, $status, $images_json,
                    $dining, $sitting_room, $garden, $balcony, $lift, $garage,
                    $property['id']
                ]);
                
                $success = "Property updated successfully.";
            } else {
                // Create new property
                $images_json = json_encode($uploaded_images);
                
                $stmt = $db->prepare("
                    INSERT INTO properties 
                    (title, description, property_type, location, price, currency, phone_display, 
                     bedrooms, bathrooms, area, featured, status, images,
                     dining, sitting_room, garden, balcony, lift, garage) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                
                $stmt->execute([
                    $title, $description, $property_type, $location,
                    $price, $currency, $phone_display, $bedrooms, $bathrooms, $area,
                    $featured, $status, $images_json,
                    $dining, $sitting_room, $garden, $balcony, $lift, $garage
                ]);
                
                $success = "Property created successfully.";
            }
            
            // Redirect after successful submission
            header('Location: properties.php');
            exit;
            
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

$user = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit ? 'Edit' : 'Add'; ?> Property - Property CMS</title>
    <link rel="stylesheet" href="admin-styles.css">
     <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }
        
        .amenity-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
        }
        
        .amenity-item input[type="checkbox"] {
            width: auto;
            margin: 0;
        }
        
        .amenity-item i {
            color: var(--primary-color);
            width: 20px;
        }
        
        .currency-phone-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include 'includes/sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'includes/header.php'; ?>
            
            <div class="content-area">
                <div class="page-header">
                    <h1><?php echo $is_edit ? 'Edit' : 'Add'; ?> Property</h1>
                    <div class="page-actions">
                        <a href="properties.php" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Back to Properties
                        </a>
                    </div>
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
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data" class="property-form">
                    <div class="form-grid">
                        <div class="form-section">
                            <h3>Basic Information</h3>
                            
                            <div class="form-group">
                                <label for="title">Property Title *</label>
                                <input type="text" id="title" name="title" required 
                                       value="<?php echo htmlspecialchars($property['title'] ?? $_POST['title'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($property['description'] ?? $_POST['description'] ?? ''); ?></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="property_type">Property Type *</label>
                                    <select id="property_type" name="property_type" required>
                                        <option value="">Select Type</option>
                                        <option value="house" <?php echo ($property['property_type'] ?? $_POST['property_type'] ?? '') === 'house' ? 'selected' : ''; ?>>House</option>
                                        <option value="apartment" <?php echo ($property['property_type'] ?? $_POST['property_type'] ?? '') === 'apartment' ? 'selected' : ''; ?>>Apartment</option>
                                        <option value="land" <?php echo ($property['property_type'] ?? $_POST['property_type'] ?? '') === 'land' ? 'selected' : ''; ?>>Land</option>
                                        <option value="commercial" <?php echo ($property['property_type'] ?? $_POST['property_type'] ?? '') === 'commercial' ? 'selected' : ''; ?>>Commercial</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="available" <?php echo ($property['status'] ?? $_POST['status'] ?? 'available') === 'available' ? 'selected' : ''; ?>>Available</option>
                                        <option value="sold" <?php echo ($property['status'] ?? $_POST['status'] ?? '') === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                        <option value="pending" <?php echo ($property['status'] ?? $_POST['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="location">Location *</label>
                                <input type="text" id="location" name="location" required 
                                       value="<?php echo htmlspecialchars($property['location'] ?? $_POST['location'] ?? ''); ?>">
                            </div>
                            
                            <div class="currency-phone-grid">
                                <div class="form-group">
                                    <label for="price">Price *</label>
                                    <div style="display: flex; gap: 10px;">
                                        <select name="currency" style="width: 80px;">
                                            <option value="TZS" <?php echo ($property['currency'] ?? $_POST['currency'] ?? 'TZS') === 'TZS' ? 'selected' : ''; ?>>TZS</option>
                                            <option value="$" <?php echo ($property['currency'] ?? $_POST['currency'] ?? '') === '$' ? 'selected' : ''; ?>>USD</option>
                                        </select>
                                        <input type="number" id="price" name="price" required min="0" step="0.01" style="flex: 1;"
                                               value="<?php echo $property['price'] ?? $_POST['price'] ?? ''; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone_display">Display Phone Number</label>
                                    <select id="phone_display" name="phone_display">
                                        <option value="phone1" <?php echo ($property['phone_display'] ?? $_POST['phone_display'] ?? 'phone1') === 'phone1' ? 'selected' : ''; ?>>
                                            Phone 1: <?php echo $settings['contact_phone'] ?? '+255 756 069 451'; ?>
                                        </option>
                                        <option value="phone2" <?php echo ($property['phone_display'] ?? $_POST['phone_display'] ?? '') === 'phone2' ? 'selected' : ''; ?>>
                                            Phone 2: <?php echo $settings['contact_phone2'] ?? '+255 755 989 743'; ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Property Details</h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="bedrooms">Bedrooms</label>
                                    <input type="number" id="bedrooms" name="bedrooms" min="0"
                                           value="<?php echo $property['bedrooms'] ?? $_POST['bedrooms'] ?? '0'; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="bathrooms">Bathrooms</label>
                                    <input type="number" id="bathrooms" name="bathrooms" min="0"
                                           value="<?php echo $property['bathrooms'] ?? $_POST['bathrooms'] ?? '0'; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="area">Area (m²)</label>
                                <input type="number" id="area" name="area" min="0" step="0.01"
                                       value="<?php echo $property['area'] ?? $_POST['area'] ?? ''; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="featured" value="1" 
                                           <?php echo ($property['featured'] ?? $_POST['featured'] ?? false) ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    Featured Property
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-section full-width">
                            <h3>Property Amenities</h3>
                            <p>Select the amenities available in this property:</p>
                            
                            <div class="amenities-grid">
                                <div class="amenity-item">
                                    <input type="checkbox" id="dining" name="dining" value="1" 
                                           <?php echo ($property['dining'] ?? $_POST['dining'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-utensils"></i>
                                    <label for="dining">Dining Room</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="sitting_room" name="sitting_room" value="1" 
                                           <?php echo ($property['sitting_room'] ?? $_POST['sitting_room'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-couch"></i>
                                    <label for="sitting_room">Sitting Room</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="garden" name="garden" value="1" 
                                           <?php echo ($property['garden'] ?? $_POST['garden'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-seedling"></i>
                                    <label for="garden">Garden</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="balcony" name="balcony" value="1" 
                                           <?php echo ($property['balcony'] ?? $_POST['balcony'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-building"></i>
                                    <label for="balcony">Balcony</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="lift" name="lift" value="1" 
                                           <?php echo ($property['lift'] ?? $_POST['lift'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-elevator"></i>
                                    <label for="lift">Lift/Elevator</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="garage" name="garage" value="1" 
                                           <?php echo ($property['garage'] ?? $_POST['garage'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-car"></i>
                                    <label for="garage">Garage</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section full-width">
                            <h3>Images</h3>
                            
                            <?php if ($is_edit && !empty($property['images'])): ?>
                                <div class="current-images">
                                    <h4>Current Images</h4>
                                    <div class="image-grid">
                                        <?php 
                                        $current_images = json_decode($property['images'], true);
                                        if (is_array($current_images)):
                                            foreach ($current_images as $image):
                                        ?>
                                            <div class="image-item">
                                                <img src="../uploads/properties/<?php echo htmlspecialchars($image); ?>" 
                                                     alt="Property Image">
                                            </div>
                                        <?php 
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label for="images"><?php echo $is_edit ? 'Upload New Images (will replace current)' : 'Upload Images'; ?></label>
                                <input type="file" id="images" name="images[]" multiple accept="image/*">
                                <small>Supported formats: JPG, JPEG, PNG, GIF, WebP. Max 5MB per image.</small>
                            </div>
                            
                            <div id="imagePreview" class="image-preview"></div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            <?php echo $is_edit ? 'Update' : 'Create'; ?> Property
                        </button>
                        <a href="properties.php" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="admin-scripts.js"></script>
    <script>
        // Image preview functionality
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            Array.from(e.target.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" style="width: 100px; height: 80px; object-fit: cover; border-radius: 5px;">
                            <span style="display: block; font-size: 0.8rem; margin-top: 5px;">${file.name}</span>
                        `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>
</html>