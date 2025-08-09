<?php
class Database {
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
<<<<<<< HEAD
    private $database = 'u145584795_promaafrica';
    private $username = 'u145584795_protas';
    private $password = 'Promaafrica@2024';
=======
    private $database = 'property_cms';
    private $username = 'root';
    private $password = '';
>>>>>>> 14f5e9e24283c5153d19a32d40ba4df87594b2eb
    private $charset = 'utf8mb4';
    
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
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
    
    public function trackVisit($page, $data = []) {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO page_visits (page_name, visit_data, ip_address, user_agent) 
                VALUES (?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $page,
                json_encode($data),
                $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
        } catch (PDOException $e) {
            error_log("Error tracking visit: " . $e->getMessage());
        }
    }
}
?>
