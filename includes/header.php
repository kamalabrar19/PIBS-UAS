<?php
// includes/header.php
require_once '../config.php';

try {
    // Ambil informasi site
    $stmt = $pdo->query('SELECT * FROM site_info LIMIT 1');
    $site = $stmt->fetch();

    // Jika belum ada data, siapkan nilai default
    if (!$site) {
        $site = [
            'logo' => '',             // Kosong (tidak ada data biner)
            'logo_type' => '',        // Kosong (tidak ada MIME)
            'site_name' => 'Nama Situs',
            'slogan' => 'Slogan Situs',
            'location' => 'Lokasi Situs'
        ];
    }
} catch (PDOException $e) {
    die("Error mengambil informasi site: " . $e->getMessage());
}
?>
<header>
    <div class="logo">
        <?php if (!empty($site['logo'])): ?>
            <!-- Menampilkan gambar dari BLOB dengan base64_encode -->
            <img src="data:<?= htmlspecialchars($site['logo_type']) ?>;base64,<?= base64_encode($site['logo']) ?>" 
                 alt="Logo" width="50">
        <?php else: ?>
            <!-- Jika tidak ada data logo, gunakan gambar default -->
            <img src="../uploads/default_logo.png" alt="Logo" width="50">
        <?php endif; ?>
    </div>
    <div class="site-info">
        <h1><?= htmlspecialchars($site['site_name']) ?></h1>
        <p><?= htmlspecialchars($site['slogan']) ?></p>
        <span><?= htmlspecialchars($site['location']) ?></span>
    </div>
</header>
