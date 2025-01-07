<?php
// add_user.php

require 'config.php';

try {
    // Tambah admin
    $admin_username = 'admin';
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $admin_role = 'admin';
    
    $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $stmt->execute([$admin_username, $admin_password, $admin_role]);
    
    // Tambah user
    $user_username = 'user';
    $user_password = password_hash('user123', PASSWORD_DEFAULT);
    $user_role = 'user';
    
    $stmt->execute([$user_username, $user_password, $user_role]);
    
    echo "Pengguna berhasil ditambahkan.";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Duplicate entry
        echo "Pengguna sudah ada di database.";
    } else {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
