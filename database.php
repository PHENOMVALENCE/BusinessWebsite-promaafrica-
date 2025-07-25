<?php
class Database {
    private static $instance = null;
    private $connection;
    
    // Database configuration
    private $host = 'localhost';
    private $database = 'promanew';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    
    private function __construct() {
        $this->connect();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];
        
        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            throw new Exception("Query execution failed. Please try again later.");
        }
    }
    
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    public function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            throw new Exception("Insert operation failed. Please try again later.");
        }
    }
    
    public function update($table, $data, $where, $whereParams = []) {
        $setClause = [];
        foreach (array_keys($data) as $key) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setClause);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_merge($data, $whereParams));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Database update failed: " . $e->getMessage());
            throw new Exception("Update operation failed. Please try again later.");
        }
    }
    
    public function delete($table, $where, $whereParams = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($whereParams);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Database delete failed: " . $e->getMessage());
            throw new Exception("Delete operation failed. Please try again later.");
        }
    }
    
    public function trackVisit($page, $metadata = []) {
        $data = [
            'page' => $page,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'metadata' => json_encode($metadata),
            'visited_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $this->insert('page_visits', $data);
        } catch (Exception $e) {
            error_log("Visit tracking failed: " . $e->getMessage());
        }
    }
    
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    public function commit() {
        return $this->connection->commit();
    }
    
    public function rollback() {
        return $this->connection->rollback();
    }
    
    public function __destruct() {
        $this->connection = null;
    }
}

// Helper function to get database connection
function getConnection() {
    return Database::getInstance()->getConnection();
}

// Property-specific helper functions
function getProperties($filters = [], $page = 1, $perPage = 12) {
    $db = Database::getInstance();
    
    $conditions = ["status = 'available'"];
    $params = [];
    
    if (!empty($filters['search'])) {
        $conditions[] = "(title LIKE :search OR description LIKE :search2 OR location LIKE :search3)";
        $params['search'] = "%{$filters['search']}%";
        $params['search2'] = "%{$filters['search']}%";
        $params['search3'] = "%{$filters['search']}%";
    }
    
    if (!empty($filters['property_type'])) {
        $conditions[] = "property_type = :property_type";
        $params['property_type'] = $filters['property_type'];
    }
    
    if (!empty($filters['location'])) {
        $conditions[] = "location LIKE :location";
        $params['location'] = "%{$filters['location']}%";
    }
    
    if (!empty($filters['min_price'])) {
        $conditions[] = "price >= :min_price";
        $params['min_price'] = $filters['min_price'];
    }
    
    if (!empty($filters['max_price'])) {
        $conditions[] = "price <= :max_price";
        $params['max_price'] = $filters['max_price'];
    }
    
    $whereClause = implode(' AND ', $conditions);
    
    $orderBy = "featured DESC, created_at DESC";
    if (!empty($filters['sort'])) {
        switch ($filters['sort']) {
            case 'newest':
                $orderBy = "created_at DESC";
                break;
            case 'price_low':
                $orderBy = "price ASC";
                break;
            case 'price_high':
                $orderBy = "price DESC";
                break;
            case 'location':
                $orderBy = "location ASC";
                break;
        }
    }
    
    $countSql = "SELECT COUNT(*) as total FROM properties WHERE {$whereClause}";
    $totalResult = $db->fetchOne($countSql, $params);
    $total = $totalResult['total'];
    
    $offset = ($page - 1) * $perPage;
    $sql = "SELECT * FROM properties WHERE {$whereClause} ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";
    $properties = $db->fetchAll($sql, $params);
    
    return [
        'properties' => $properties,
        'total' => $total,
        'pages' => ceil($total / $perPage),
        'current_page' => $page
    ];
}

function getPropertyById($id) {
    $db = Database::getInstance();
    $sql = "SELECT * FROM properties WHERE id = :id";
    return $db->fetchOne($sql, ['id' => $id]);
}

function updatePropertyViews($id) {
    $db = Database::getInstance();
    $sql = "UPDATE properties SET views = COALESCE(views, 0) + 1 WHERE id = :id";
    return $db->query($sql, ['id' => $id]);
}

function saveInquiry($data) {
    $db = Database::getInstance();
    
    $inquiryData = [
        'property_id' => $data['property_id'] ?? null,
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'] ?? null,
        'message' => $data['message'],
        'status' => 'new',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    // Update property inquiry count
    if ($inquiryData['property_id']) {
        $db->query("UPDATE properties SET inquiries = COALESCE(inquiries, 0) + 1 WHERE id = :id", 
                  ['id' => $inquiryData['property_id']]);
    }
    
    return $db->insert('property_inquiries', $inquiryData);
}

function getSettings() {
    $db = Database::getInstance();
    $sql = "SELECT setting_key, setting_value FROM settings";
    $results = $db->fetchAll($sql);
    
    $settings = [];
    foreach ($results as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    return $settings;
}
?>
