<?php
require_once 'config/database.php';
$db = Database::getInstance();
$pdo = $db->getConnection();
try {
    $stmt = $pdo->query("SELECT 1");
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}