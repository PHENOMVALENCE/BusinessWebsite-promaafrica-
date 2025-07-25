<?php
require_once 'auth.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$image_name = $input['image'] ?? '';
$property_id = intval($input['property_id'] ?? 0);

if (empty($image_name) || $property_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

$db = Database::getInstance()->getConnection();

try {
    // Get current property images
    $stmt = $db->prepare("SELECT images FROM properties WHERE id = ?");
    $stmt->execute([$property_id]);
    $property = $stmt->fetch();
    
    if (!$property) {
        echo json_encode(['success' => false, 'message' => 'Property not found']);
        exit;
    }
    
    $current_images = json_decode($property['images'], true);
    if (!is_array($current_images)) {
        echo json_encode(['success' => false, 'message' => 'No images found']);
        exit;
    }
    
    // Remove the image from the array
    $updated_images = array_filter($current_images, function($img) use ($image_name) {
        return $img !== $image_name;
    });
    
    // Update the database
    $stmt = $db->prepare("UPDATE properties SET images = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([json_encode(array_values($updated_images)), $property_id]);
    
    // Delete the physical file
    $file_path = '../uploads/properties/' . $image_name;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    echo json_encode(['success' => true, 'message' => 'Image deleted successfully']);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
