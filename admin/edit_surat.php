<?php
// admin/edit_surat.php
require_once '../config.php';

// Cek apakah user sudah login dan role-nya 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Cek apakah ada parameter 'id' di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: data_surat.php');
    exit;
}

$surat_id = $_GET['id'];
$error = '';
$success = '';

// Ambil data surat
$stmt = $pdo->prepare('SELECT * FROM surat WHERE id = ?');
$stmt->execute([$surat_id]);
$surat = $stmt->fetch();

if (!$surat) {
    header('Location: data_surat.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi input
    $title = trim($_POST['title']);
    $type = $_POST['type'];
    $content = trim($_POST['content']);

    // Validasi input
    if (empty($title) || empty($type) || empty($content)) {
        $error = "Semua field wajib diisi.";
    } elseif (!in_array($type, ['internal', 'external'])) {
        $error = "Jenis surat tidak valid.";
    } else {
        // Update ke database
        $stmt = $pdo->prepare('UPDATE surat SET title = ?, type = ?, content = ? WHERE id = ?');
        if ($stmt->execute([$title, $type, $content, $surat_id])) {
            $success = "Surat berhasil diperbarui.";
            // Update data surat
            $surat['title'] = $title;
            $surat['type'] = $type;
            $surat['content'] = $content;
        } else {
            $error = "Terjadi kesalahan saat memperbarui surat.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Surat - Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/nav_admin.php'; ?>
    <main>
        <?php include '../includes/aside_admin.php'; ?>
        <section class="content">
            <h2>Edit Surat</h2>
            <?php if($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if($success): ?>
                <p class="success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label>Judul Surat:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($surat['title']) ?>" required>

                <label>Jenis Surat:</label>
                <select name="type" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="internal" <?= ($surat['type'] === 'internal') ? 'selected' : '' ?>>Internal</option>
                    <option value="external" <?= ($surat['type'] === 'external') ? 'selected' : '' ?>>External</option>
                </select>

                <label>Isi Surat:</label>
                <textarea name="content" rows="5" required><?= htmlspecialchars($surat['content']) ?></textarea>

                <button type="submit">Perbarui Surat</button>
            </form>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
