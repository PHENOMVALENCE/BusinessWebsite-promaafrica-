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
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($full_name)) $errors[] = "Full name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    
    // Check if email is already taken by another user
    try {
        $stmt = $db->prepare("SELECT id FROM admin_users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user['id']]);
        if ($stmt->fetch()) {
            $errors[] = "Email is already taken by another user.";
        }
    } catch (PDOException $e) {
        $errors[] = "Database error: " . $e->getMessage();
    }
    
    // Password validation if changing password
    if (!empty($new_password)) {
        if (empty($current_password)) {
            $errors[] = "Current password is required to change password.";
        } else {
            // Verify current password
            try {
                $stmt = $db->prepare("SELECT password FROM admin_users WHERE id = ?");
                $stmt->execute([$user['id']]);
                $stored_password = $stmt->fetchColumn();
                
                if (!password_verify($current_password, $stored_password)) {
                    $errors[] = "Current password is incorrect.";
                }
            } catch (PDOException $e) {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
        
        if (strlen($new_password) < 6) {
            $errors[] = "New password must be at least 6 characters long.";
        }
        
        if ($new_password !== $confirm_password) {
            $errors[] = "New password and confirmation do not match.";
        }
    }
    
    // Update profile if no errors
    if (empty($errors)) {
        try {
            if (!empty($new_password)) {
                // Update with new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE admin_users SET full_name = ?, email = ?, password = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$full_name, $email, $hashed_password, $user['id']]);
            } else {
                // Update without password change
                $stmt = $db->prepare("UPDATE admin_users SET full_name = ?, email = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$full_name, $email, $user['id']]);
            }
            
            // Update session data
            $_SESSION['admin_user']['full_name'] = $full_name;
            $_SESSION['admin_user']['email'] = $email;
            
            $success = "Profile updated successfully.";
            $user = $auth->getUser(); // Refresh user data
            
        } catch (PDOException $e) {
            $errors[] = "Error updating profile: " . $e->getMessage();
        }
    }
}

// Get user's login history
try {
    $stmt = $db->prepare("SELECT last_login, created_at FROM admin_users WHERE id = ?");
    $stmt->execute([$user['id']]);
    $user_details = $stmt->fetch();
} catch (PDOException $e) {
    $user_details = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Property CMS</title>
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
                    <h1>Profile Settings</h1>
                    <p>Manage your account information and security settings</p>
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
                
                <div class="profile-grid">
                    <!-- Profile Information -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h2>Profile Information</h2>
                        </div>
                        
                        <form method="POST" class="profile-form">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                                <small>Username cannot be changed</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="full_name">Full Name *</label>
                                <input type="text" id="full_name" name="full_name" required 
                                       value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required 
                                       value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="text" id="role" value="<?php echo ucfirst(htmlspecialchars($user['role'])); ?>" disabled>
                                <small>Role can only be changed by system administrator</small>
                            </div>
                            
                            <div class="form-section-divider">
                                <h3>Change Password</h3>
                                <p>Leave blank if you don't want to change your password</p>
                            </div>
                            
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" id="new_password" name="new_password" minlength="6">
                                    <small>Minimum 6 characters</small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" minlength="6">
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save"></i>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Account Information -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h2>Account Information</h2>
                        </div>
                        
                        <div class="account-info">
                            <div class="info-item">
                                <div class="info-label">Account Created</div>
                                <div class="info-value">
                                    <?php echo $user_details ? date('F j, Y \a\t g:i A', strtotime($user_details['created_at'])) : 'Unknown'; ?>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">Last Login</div>
                                <div class="info-value">
                                    <?php echo $user_details && $user_details['last_login'] ? date('F j, Y \a\t g:i A', strtotime($user_details['last_login'])) : 'Never'; ?>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">User ID</div>
                                <div class="info-value">#<?php echo $user['id']; ?></div>
                            </div>
                        </div>
                        
                        <div class="security-section">
                            <h3>Security Tips</h3>
                            <ul class="security-tips">
                                <li><i class="fas fa-shield-alt"></i> Use a strong, unique password</li>
                                <li><i class="fas fa-lock"></i> Don't share your login credentials</li>
                                <li><i class="fas fa-sign-out-alt"></i> Always log out when finished</li>
                                <li><i class="fas fa-eye"></i> Regularly review your account activity</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="admin-scripts.js"></script>
    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword && confirmPassword && newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
