<?php
// includes/footer.php
require_once '../config.php';

try {
    // Ambil informasi site
    $stmt = $pdo->query('SELECT * FROM site_info LIMIT 1');
    $site = $stmt->fetch();

    if (!$site) {
        $site = [
            'logo' => '',
            'logo_type' => '',
            'site_name' => 'Nama Situs',
            'slogan' => 'Slogan Situs',
            'location' => 'Lokasi Situs'
        ];
    }
} catch (PDOException $e) {
    die("Error mengambil informasi site: " . $e->getMessage());
}
?>
<footer>
    <div class="footer-logo">
        <?php if (!empty($site['logo'])): ?>
            <img src="data:<?= htmlspecialchars($site['logo_type']) ?>;base64,<?= base64_encode($site['logo']) ?>" 
                 alt="Logo" width="50">
        <?php else: ?>
            <img src="../uploads/default_logo.png" alt="Logo" width="50">
        <?php endif; ?>
    </div>
    <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($site['site_name']) ?>. <?= htmlspecialchars($site['slogan']) ?></p>
    <span><?= htmlspecialchars($site['location']) ?></span>
</footer>
