<?php
// admin/data_surat.php
require_once '../config.php'; // Pastikan file ini sudah menangani session_start()

// Cek apakah user sudah login dan role-nya 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Ambil semua surat dari database
$stmt = $pdo->query('SELECT surat.*, users.username FROM surat JOIN users ON surat.user_id = users.id ORDER BY surat.created_at DESC');
$surats = $stmt->fetchAll();

// Proses tambah surat jika form disubmit (dari modal popup)
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['type'];
    $created_at = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session
    $file_path = null;

    // Validasi dan upload file
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        $file_name = basename($_FILES['pdf_file']['name']);
        $file_tmp = $_FILES['pdf_file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_ext === 'pdf') {
            $unique_name = uniqid('pdf_', true) . '.' . $file_ext;
            $file_path = $upload_dir . $unique_name;

            if (!move_uploaded_file($file_tmp, $file_path)) {
                $error = "Gagal mengunggah file.";
            }
        } else {
            $error = "Hanya file PDF yang diperbolehkan.";
        }
    }

    // Validasi data
    if (!empty($title) && !empty($content) && !empty($type)) {
        // Insert data ke database
        $stmt = $pdo->prepare('INSERT INTO surat (user_id, title, content, type, file_path, created_at) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $title, $content, $type, $file_path, $created_at]);

        // Redirect setelah berhasil menambahkan surat
        header('Location: data_surat.php');
        exit;
    } else {
        $error = "Semua field harus diisi.";
    }
}

// Proses update data jika form disubmit (dari modal popup)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['type'];
    $file_path = $_POST['file_path']; // Simpan file path lama jika tidak ada file baru yang di-upload

    // Cek apakah ada file baru yang di-upload
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        $file_name = basename($_FILES['pdf_file']['name']);
        $file_tmp = $_FILES['pdf_file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_ext === 'pdf') {
            $unique_name = uniqid('pdf_', true) . '.' . $file_ext;
            $file_path = $upload_dir . $unique_name;

            if (!move_uploaded_file($file_tmp, $file_path)) {
                $error = "Gagal mengunggah file.";
            }
        } else {
            $error = "Hanya file PDF yang diperbolehkan.";
        }
    }

    // Update surat di database
    $stmt = $pdo->prepare('UPDATE surat SET title = ?, content = ?, type = ?, file_path = ? WHERE id = ?');
    $stmt->execute([$title, $content, $type, $file_path, $id]);

    header('Location: data_surat.php');
    exit;
}

// Proses hapus data jika tombol hapus ditekan
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare('DELETE FROM surat WHERE id = ?');
    $stmt->execute([$delete_id]);

    header('Location: data_surat.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Data Surat</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        header {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        footer {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            position: relative;
            bottom: 0;
        }

        main {
            display: flex;
            flex-wrap: wrap; /* Memungkinkan elemen untuk membungkus ke baris berikutnya */
            min-height: 80vh;
        }

        /* Side Navigation */
        .side-nav {
            width: 25%;
            background-color: #2c3e50;
            color: #ecf0f1;
            min-height: 600px; /* Sesuaikan jika diperlukan */
            padding: 20px;
            box-sizing: border-box; /* Pastikan padding dihitung dalam width */
            font-family: Arial, sans-serif;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .side-nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .side-nav li {
            margin-bottom: 10px;
        }

        .side-nav a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            transition: background 0.3s, color 0.3s;
            border-radius: 4px;
        }

        .side-nav a:hover {
            background-color: #34495e;
            color: #fff;
        }

        /* Content Section */
        .content {
            width: 50%;
            padding: 20px;
            background-color: #fff;
        }

        /* Aside Section */
        .aside {
            width: 25%;
            background-color: #2c3e50;
            color: #ecf0f1;
            min-height: 600px; /* Sesuaikan jika diperlukan */
            padding: 20px;
            box-sizing: border-box; /* Pastikan padding dihitung dalam width */
            font-family: Arial, sans-serif;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); /* Bayangan ke kiri */
        }

        .aside h3 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .aside p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .aside ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .aside li {
            margin-bottom: 15px;
        }

        .aside a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            background-color: #34495e;
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
        }

        .aside a:hover {
            background-color: #2c3e50;
            color: #fff;
        }

        /* ====== Responsivitas ====== */

        /* Tablet */
        @media (max-width: 992px) and (min-width: 768px) {
            .side-nav {
                width: 25%;
                border-right: 1px solid #ddd;
                border-bottom: none;
            }

            .content {
                width: 75%;
            }

            .aside {
                width: 100%;
                border-left: none;
                border-top: 1px solid #ddd;
                margin-top: 20px; /* Memberi jarak atas aside */
            }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .side-nav,
            .content,
            .aside {
                width: 100%;
                border: none;
                padding: 15px;
            }

            main {
                flex-direction: column; /* Menyusun elemen secara vertikal */
            }

            .aside {
                margin-top: 20px; /* Memberi jarak atas aside */
            }
        }

        /* ====== Gaya Tabel dan Komponen Lainnya Tetap ====== */

        /* CRUD Table */
        .crud-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            overflow-x: auto;
        }

        .crud-table th, .crud-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .crud-table th {
            background-color: #f4f4f4;
        }

        .crud-table a {
            color: #007BFF;
            text-decoration: none;
        }

        .crud-table img {
            width: 20px;
            height: 20px;
            vertical-align: middle;
        }

        .edit-btn, .delete-btn {
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
            border: none;
            margin-right: 5px;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* ====== Tambahan CSS untuk Modal Popup Tetap Tetap ====== */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 999; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .modal form input[type="text"],
        .modal form textarea,
        .modal form select {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal form input[type="file"] {
            margin-bottom: 15px;
        }

        .modal form button {
            padding: 10px 15px;
            background-color: #007BFF;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal form button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        /* ====== Responsivitas Tambahan untuk Modal Tetap ====== */
        @media (max-width: 992px) and (min-width: 768px) {
            .modal-content {
                width: 60%;
            }
        }

        @media (max-width: 767px) {
            .modal-content {
                width: 90%;
            }

            .modal form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <?php include '../includes/nav_admin.php'; ?>

        <section class="content">
            <h2>Data Surat</h2>

            <!-- Tombol Baru untuk Popup Tambah Surat -->
            <button class="edit-btn" id="openAddModalBtn">Tambah Surat</button>

            <!-- Tampilkan error jika ada -->
            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Tabel Surat -->
            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Judul Surat</th>
                        <th>Jenis Surat</th>
                        <th>Pengguna</th>
                        <th>Tanggal Dibuat</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($surats as $surat): ?>
                        <tr>
                            <td><?= htmlspecialchars($surat['title']) ?></td>
                            <td><?= htmlspecialchars(ucfirst($surat['type'])) ?></td>
                            <td><?= htmlspecialchars($surat['username']) ?></td>
                            <td><?= htmlspecialchars(date('d M Y H:i', strtotime($surat['created_at']))) ?></td>
                            <td>
                                <?php if ($surat['file_path']): ?>
                                    <a href="<?= htmlspecialchars($surat['file_path']) ?>" target="_blank">
                                        <img src="../assets/pdfIcon.png" alt="PDF"> <br>Lihat Surat
                                    </a>
                                <?php else: ?>
                                    Tidak ada file
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Tombol Edit Surat (modal) -->
                                <button class="edit-btn editSuratBtn" 
                                        data-id="<?= $surat['id'] ?>" 
                                        data-title="<?= htmlspecialchars($surat['title']) ?>" 
                                        data-content="<?= htmlspecialchars($surat['content']) ?>"
                                        data-type="<?= htmlspecialchars($surat['type']) ?>"
                                        data-file="<?= htmlspecialchars($surat['file_path']) ?>">
                                    Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <a href="?delete_id=<?= $surat['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                    <button class="delete-btn">Hapus</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <?php include '../includes/aside_admin.php'; ?>
    </main>
    <?php include '../includes/footer.php'; ?>

    <!-- ========== MODAL TAMBAH SURAT ========== -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddModal">&times;</span>
            <h2>Tambah Surat</h2>
            <form action="data_surat.php" method="POST" enctype="multipart/form-data">
                <label for="title">Judul Surat:</label>
                <input type="text" id="title" name="title" required>

                <label for="content">Isi Surat:</label>
                <textarea id="content" name="content" rows="4" required></textarea>

                <label for="type">Jenis Surat:</label>
                <select id="type" name="type" required>
                    <option value="">Pilih Jenis</option>
                    <option value="internal" <?= (isset($_POST['type']) && $_POST['type'] === 'internal') ? 'selected' : '' ?>>Internal</option>
                    <option value="external" <?= (isset($_POST['type']) && $_POST['type'] === 'external') ? 'selected' : '' ?>>External</option>
                </select>

                <label for="pdf_file">File PDF:</label>
                <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf">

                <button type="submit" name="submit">Tambah</button>
            </form>
        </div>
    </div>

    <!-- ========== MODAL EDIT SURAT ========== -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Edit Surat</h2>
            <form action="data_surat.php" method="POST" enctype="multipart/form-data">
                <!-- Hidden input untuk ID dan file path lama -->
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="file_path" id="edit_file_path">

                <label for="edit_title">Judul Surat:</label>
                <input type="text" id="edit_title" name="title" required>

                <label for="edit_content">Isi Surat:</label>
                <textarea id="edit_content" name="content" rows="4" required></textarea>

                <label for="edit_type">Jenis Surat:</label>
                <select id="edit_type" name="type" required>
                    <option value="">Pilih Jenis</option>
                    <option value="internal">Internal</option>
                    <option value="external">External</option>
                </select>

                <label for="edit_pdf_file">File PDF (Jika tidak diubah, kosongkan):</label>
                <input type="file" id="edit_pdf_file" name="pdf_file" accept="application/pdf">

                <button type="submit" name="update">Update</button>
            </form>
        </div>
    </div>

    <!-- ========== SCRIPT UNTUK MODAL POPUP ========== -->
    <script>
        // ============= MODAL TAMBAH SURAT =============
        const addModal = document.getElementById('addModal');
        const openAddModalBtn = document.getElementById('openAddModalBtn');
        const closeAddModal = document.getElementById('closeAddModal');

        // Buka modal tambah
        openAddModalBtn.onclick = function() {
            addModal.style.display = 'block';
        }

        // Tutup modal tambah
        closeAddModal.onclick = function() {
            addModal.style.display = 'none';
        }

        // Klik di luar modal
        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.style.display = 'none';
            }
            if (event.target == editModal) {
                editModal.style.display = 'none';
            }
        }

        // ============= MODAL EDIT SURAT =============
        const editModal = document.getElementById('editModal');
        const closeEditModal = document.getElementById('closeEditModal');
        const editSuratButtons = document.querySelectorAll('.editSuratBtn');

        // Buka modal edit & isi form
        editSuratButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const content = this.getAttribute('data-content');
                const type = this.getAttribute('data-type');
                const filePath = this.getAttribute('data-file');

                // Isi form edit
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_title').value = title;
                document.getElementById('edit_content').value = content;
                document.getElementById('edit_type').value = type;
                document.getElementById('edit_file_path').value = filePath;

                // Tampilkan modal
                editModal.style.display = 'block';
            });
        });

        // Tutup modal edit
        closeEditModal.onclick = function() {
            editModal.style.display = 'none';
        }
    </script>
</body>
</html>
