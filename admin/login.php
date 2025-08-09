<?php
require_once 'auth.php';

$auth = new Auth();
$error = '';

if ($_POST) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } elseif ($auth->login($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}

if ($auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Property CMS</title>
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-form">
            <div class="login-header">
                <h1>Property CMS</h1>
                <p>Admin Panel Login</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username or Email</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-login">Login</button>
            </form>
            
            <div class="login-footer">
                <p>Default credentials: admin / admin123</p>
            </div>
        </div>
    </div>
</body>
</html>
