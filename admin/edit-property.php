<?php
require_once 'auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$db = Database::getInstance()->getConnection();

$property = null;
$is_edit = true;

// Get property for editing
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: properties.php');
    exit;
}

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
    $keep_existing_images = isset($_POST['keep_existing_images']);
    
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
            // Determine final images
            $final_images = [];
            
            if ($keep_existing_images && !empty($property['images'])) {
                $existing_images = json_decode($property['images'], true);
                if (is_array($existing_images)) {
                    $final_images = array_merge($final_images, $existing_images);
                }
            }
            
            if (!empty($uploaded_images)) {
                $final_images = array_merge($final_images, $uploaded_images);
            }
            
            // If no images at all, keep existing or set empty
            if (empty($final_images) && !empty($property['images'])) {
                $final_images = json_decode($property['images'], true);
            }
            
            $images_json = json_encode($final_images);
            
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
            
            // If not keeping existing images and we have new ones, delete old images
            if (!$keep_existing_images && !empty($uploaded_images) && !empty($property['images'])) {
                $old_images = json_decode($property['images'], true);
                if (is_array($old_images)) {
                    foreach ($old_images as $old_image) {
                        $old_path = $upload_dir . $old_image;
                        if (file_exists($old_path)) {
                            unlink($old_path);
                        }
                    }
                }
            }
            
            $success = "Property updated successfully.";
            
            // Refresh property data
            $stmt = $db->prepare("SELECT * FROM properties WHERE id = ?");
            $stmt->execute([$property['id']]);
            $property = $stmt->fetch();
            
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
    <title>Edit Property - Property CMS</title>
    <link rel="stylesheet" href="admin-styles.css">
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
                    <h1>Edit Property</h1>
                    <div class="page-actions">
                        <a href="properties.php" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Back to Properties
                        </a>
                        <a href="../sales.php?view=<?php echo $property['id']; ?>" target="_blank" class="btn-info">
                            <i class="fas fa-external-link-alt"></i>
                            View on Site
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
                                       value="<?php echo htmlspecialchars($property['title']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($property['description']); ?></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="property_type">Property Type *</label>
                                    <select id="property_type" name="property_type" required>
                                        <option value="">Select Type</option>
                                        <option value="house" <?php echo $property['property_type'] === 'house' ? 'selected' : ''; ?>>House</option>
                                        <option value="apartment" <?php echo $property['property_type'] === 'apartment' ? 'selected' : ''; ?>>Apartment</option>
                                        <option value="land" <?php echo $property['property_type'] === 'land' ? 'selected' : ''; ?>>Land</option>
                                        <option value="commercial" <?php echo $property['property_type'] === 'commercial' ? 'selected' : ''; ?>>Commercial</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="available" <?php echo $property['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                                        <option value="sold" <?php echo $property['status'] === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                        <option value="pending" <?php echo $property['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="location">Location *</label>
                                <input type="text" id="location" name="location" required 
                                       value="<?php echo htmlspecialchars($property['location']); ?>">
                            </div>
                            
                            <div class="currency-phone-grid">
                                <div class="form-group">
                                    <label for="price">Price *</label>
                                    <div style="display: flex; gap: 10px;">
                                        <select name="currency" style="width: 80px;">
                                            <option value="TZS" <?php echo ($property['currency'] ?? 'TZS') === 'TZS' ? 'selected' : ''; ?>>TZS</option>
                                            <option value="$" <?php echo ($property['currency'] ?? '') === '$' ? 'selected' : ''; ?>>USD</option>
                                        </select>
                                        <input type="number" id="price" name="price" required min="0" step="0.01" style="flex: 1;"
                                               value="<?php echo $property['price']; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone_display">Display Phone Number</label>
                                    <select id="phone_display" name="phone_display">
                                        <option value="phone1" <?php echo ($property['phone_display'] ?? 'phone1') === 'phone1' ? 'selected' : ''; ?>>
                                            Phone 1: <?php echo $settings['contact_phone'] ?? 'Not Set'; ?>
                                        </option>
                                        <option value="phone2" <?php echo ($property['phone_display'] ?? '') === 'phone2' ? 'selected' : ''; ?>>
                                            Phone 2: <?php echo $settings['contact_phone2'] ?? 'Not Set'; ?>
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
                                           value="<?php echo $property['bedrooms']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="bathrooms">Bathrooms</label>
                                    <input type="number" id="bathrooms" name="bathrooms" min="0"
                                           value="<?php echo $property['bathrooms']; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="area">Area (m²)</label>
                                <input type="number" id="area" name="area" min="0" step="0.01"
                                       value="<?php echo $property['area']; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="featured" value="1" 
                                           <?php echo $property['featured'] ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    Featured Property
                                </label>
                            </div>
                            
                            <div class="property-stats">
                                <h4>Property Statistics</h4>
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <span class="stat-label">Views:</span>
                                        <span class="stat-value"><?php echo number_format($property['views']); ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Created:</span>
                                        <span class="stat-value"><?php echo date('M j, Y', strtotime($property['created_at'])); ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Updated:</span>
                                        <span class="stat-value"><?php echo date('M j, Y', strtotime($property['updated_at'])); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section full-width">
                            <h3>Property Amenities</h3>
                            <p>Select the amenities available in this property:</p>
                            
                            <div class="amenities-grid">
                                <div class="amenity-item">
                                    <input type="checkbox" id="dining" name="dining" value="1" 
                                           <?php echo ($property['dining'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-utensils"></i>
                                    <label for="dining">Dining Room</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="sitting_room" name="sitting_room" value="1" 
                                           <?php echo ($property['sitting_room'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-couch"></i>
                                    <label for="sitting_room">Sitting Room</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="garden" name="garden" value="1" 
                                           <?php echo ($property['garden'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-seedling"></i>
                                    <label for="garden">Garden</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="balcony" name="balcony" value="1" 
                                           <?php echo ($property['balcony'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-building"></i>
                                    <label for="balcony">Balcony</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="lift" name="lift" value="1" 
                                           <?php echo ($property['lift'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-elevator"></i>
                                    <label for="lift">Lift/Elevator</label>
                                </div>
                                
                                <div class="amenity-item">
                                    <input type="checkbox" id="garage" name="garage" value="1" 
                                           <?php echo ($property['garage'] ?? false) ? 'checked' : ''; ?>>
                                    <i class="fas fa-car"></i>
                                    <label for="garage">Garage</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section full-width">
                            <h3>Images</h3>
                            
                            <?php if (!empty($property['images'])): ?>
                                <div class="current-images">
                                    <h4>Current Images</h4>
                                    <div class="image-grid">
                                        <?php 
                                        $current_images = json_decode($property['images'], true);
                                        if (is_array($current_images)):
                                            foreach ($current_images as $index => $image):
                                        ?>
                                            <div class="image-item">
                                                <img src="../uploads/properties/<?php echo htmlspecialchars($image); ?>" 
                                                     alt="Property Image <?php echo $index + 1; ?>">
                                                <div class="image-actions">
                                                    <button type="button" class="btn-delete-image" 
                                                            onclick="deleteImage('<?php echo htmlspecialchars($image); ?>', <?php echo $property['id']; ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php 
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="keep_existing_images" value="1" checked>
                                            <span class="checkmark"></span>
                                            Keep existing images when uploading new ones
                                        </label>
                                        <small>Uncheck this to replace all existing images with new uploads</small>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label for="images">Upload New Images</label>
                                <input type="file" id="images" name="images[]" multiple accept="image/*">
                                <small>Supported formats: JPG, JPEG, PNG, GIF, WebP. Max 5MB per image.</small>
                            </div>
                            
                            <div id="imagePreview" class="image-preview"></div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Update Property
                        </button>
                        <a href="properties.php" class="btn-secondary">Cancel</a>
                        <button type="button" class="btn-danger" onclick="deleteProperty(<?php echo $property['id']; ?>)">
                            <i class="fas fa-trash"></i>
                            Delete Property
                        </button>
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
        
        function deleteImage(imageName, propertyId) {
            if (confirm('Are you sure you want to delete this image?')) {
                // In a real implementation, this would make an AJAX call to delete the image
                fetch('delete-image.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        image: imageName,
                        property_id: propertyId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting image: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error deleting image');
                });
            }
        }
        
        function deleteProperty(propertyId) {
            if (confirm('Are you sure you want to delete this property? This action cannot be undone.')) {
                window.location.href = `properties.php?delete=${propertyId}`;
            }
        }
    </script>
</body>
</html>