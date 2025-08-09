<?php
require_once '../config/database.php';

if ($_POST) {
    $db = Database::getInstance()->getConnection();
    
    try {
        $stmt = $db->prepare("
            INSERT INTO inquiries (property_id, name, email, phone, message) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $_POST['property_id'] ?: null,
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'] ?: null,
            $_POST['message']
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Inquiry submitted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error submitting inquiry']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
