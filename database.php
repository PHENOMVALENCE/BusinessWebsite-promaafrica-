<?php
class Database {
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
    private $username = 'u145584795_root';
    private $password = 'Promaafrica@2024';
    private $database = 'u145584795_proma';
    
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Helper method to track page visits
    public function trackVisit($pageType, $pageId = null) {
        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO analytics (page_type, page_id, visitor_ip, user_agent, referrer, visit_date) 
                 VALUES (?, ?, ?, ?, ?, NOW())"
            );
            $stmt->execute([
                $pageType,
                $pageId,
                $_SERVER['REMOTE_ADDR'] ?? '',
                $_SERVER['HTTP_USER_AGENT'] ?? '',
                $_SERVER['HTTP_REFERER'] ?? ''
            ]);
        } catch(PDOException $e) {
            // Log error but don't break the page
            error_log("Analytics tracking error: " . $e->getMessage());
        }
    }
}

// Helper function for backward compatibility
function getConnection() {
    return Database::getInstance()->getConnection();
}

// Helper function to get property image with fallback
function getPropertyImage($imagePath) {
    if (empty($imagePath)) {
        return 'assets/images/placeholder-property.jpg';
    }
    
    // Handle JSON array of images (take first one)
    if (strpos($imagePath, '[') === 0) {
        $images = json_decode($imagePath, true);
        if (is_array($images) && !empty($images)) {
            $imagePath = $images[0];
        }
    }
    
    // Check if file exists
    $fullPath = 'uploads/properties/' . $imagePath;
    if (file_exists($fullPath)) {
        return $fullPath;
    }
    
    return 'assets/images/placeholder-property.jpg';
}

// Helper function to format price
function formatPrice($price) {
    if ($price >= 1000000000) {
        return 'TSh ' . number_format($price / 1000000000, 1) . 'B';
    } elseif ($price >= 1000000) {
        return 'TSh ' . number_format($price / 1000000, 1) . 'M';
    } else {
        return 'TSh ' . number_format($price);
    }
}
?>
