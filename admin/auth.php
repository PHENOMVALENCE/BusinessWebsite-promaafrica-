<?php
session_start();
require_once '../config/database.php';

class Auth {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function login($username, $password) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM admin_users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ];
                
                // Update last login
                $update_stmt = $this->db->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                $update_stmt->execute([$user['id']]);
                
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: login.php');
        exit;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['admin_user']);
    }
    
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }
    
    public function getUser() {
        return $_SESSION['admin_user'] ?? null;
    }
    
    public function hasRole($role) {
        $user = $this->getUser();
        return $user && $user['role'] === $role;
    }
}
?>
