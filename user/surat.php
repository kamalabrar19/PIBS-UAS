<?php
// user/surat.php
session_start();
require '../config.php';

// Cek apakah user sudah login dan role-nya 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php');
    exit;
}

// Inisialisasi variabel error
$error = '';

// Proses untuk menambahkan surat
if (isset($_POST['submit'])) {
    // Ambil dan sanitasi input
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $type = trim($_POST['type']);
    $created_at = date('Y-m-d H:i:s'); // Timestamp saat surat ditambahkan
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session

    // Validasi file
    $file_path = null;
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../admin/uploads/'; // Folder untuk menyimpan file

        // Buat folder jika belum ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['pdf_file']['name']);
        $file_tmp = $_FILES['pdf_file']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_ext === 'pdf') {
            $unique_name = uniqid('pdf_', true) . '.' . $file_ext; // Nama file unik
            $file_path_full = $upload_dir . $unique_name;

            if (!move_uploaded_file($file_tmp, $file_path_full)) {
                $error = "Gagal memindahkan file ke direktori tujuan.";
            } else {
                // Jika berhasil, simpan path relatif ke database
                $file_path = 'uploads/' . $unique_name;
            }
        } else {
            $error = "Hanya file PDF yang diperbolehkan.";
        }
    }

    // Validasi data
    if (!empty($title) && !empty($content) && !empty($type) && empty($error)) {
        // Insert data ke database menggunakan prepared statements
        $stmt = $pdo->prepare('INSERT INTO surat (user_id, title, content, type, file_path, created_at) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $title, $content, $type, $file_path, $created_at]);

        // Redirect setelah berhasil menambahkan surat dengan parameter success
        header('Location: surat.php?success=1');
        exit;
    } elseif (empty($error)) {
        $error = "Semua field harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Surat - User</title>
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
            background: linear-gradient(135deg, #004aad, #007bff);
            color: #fff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }


        main {
            display: flex;
            min-height: 80vh;
        }

        .side-nav {
            width: 25%;
            background-color: #fff;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .aside {
            width: 25%;
            background-color: #fff;
            padding: 20px;
            border-left: 1px solid #ddd;
        }

        .content {
            width: 50%;
            padding: 20px;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }

        footer {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Header -->
    <main>
        <?php include '../includes/nav_user.php'; ?> <!-- Navigation -->
        <section class="content">
            <div class="container">
                <h2>Tambah Surat Baru</h2>

                <!-- Menampilkan pesan sukses jika ada -->
                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div id="success-message" class="success">Surat berhasil ditambahkan!</div>
                    <script>
                        // Menghilangkan pesan sukses setelah 1 detik
                        setTimeout(function() {
                            var msg = document.getElementById('success-message');
                            if (msg) {
                                msg.style.display = 'none';
                            }
                        }, 2000); // 1000 milidetik = 1 detik
                    </script>
                <?php endif; ?>

                <!-- Menampilkan pesan error jika ada -->
                <?php if (!empty($error)): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="title">Judul Surat:</label>
                    <input type="text" name="title" id="title" placeholder="Masukkan judul surat" required value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">

                    <label for="content">Isi Surat:</label>
                    <textarea name="content" id="content" rows="5" placeholder="Masukkan isi surat" required><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>

                    <label for="type">Jenis Surat:</label>
                    <select name="type" id="type" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        <option value="internal" <?= (isset($_POST['type']) && $_POST['type'] === 'internal') ? 'selected' : '' ?>>Internal</option>
                        <option value="external" <?= (isset($_POST['type']) && $_POST['type'] === 'external') ? 'selected' : '' ?>>External</option>
                    </select>

                    <label for="pdf_file">Unggah File (PDF):</label>
                    <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf">

                    <button type="submit" name="submit">Tambah Surat</button>
                </form>
            </div>
        </section>
        <?php include '../includes/aside_user.php'; ?> <!-- Sidebar -->
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>
</html>
