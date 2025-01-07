<?php
// admin/delete_surat.php
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

// Hapus surat dari database
$stmt = $pdo->prepare('DELETE FROM surat WHERE id = ?');
if ($stmt->execute([$surat_id])) {
    header('Location: data_surat.php?message=Surat berhasil dihapus');
    exit;
} else {
    header('Location: data_surat.php?error=Terjadi kesalahan saat menghapus surat');
    exit;
}
?>
