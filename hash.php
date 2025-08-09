<?php
$password = 'Proma@2025';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Hashed Password: " . $hashedPassword;
?>
