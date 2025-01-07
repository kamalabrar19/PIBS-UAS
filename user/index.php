<?php
// admin/index.php
require_once '../config.php';

// Cek apakah user sudah login dan role-nya 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <!-- CSS Internal -->
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

        /* Header */
        header {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo img {
            max-width: 50px;
            height: auto;
            margin-right: 15px;
        }

        .site-info h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .site-info p, .site-info span {
            font-size: 14px;
        }

        /* Layout Utama */
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

        .content h2 {
            margin-bottom: 15px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #555;
        }

        /* Aside Section */
        .aside-admin {
            width: 25%;
            background-color: #2c3e50;
            color: #ecf0f1;
            min-height: 600px; /* Sesuaikan jika diperlukan */
            padding: 20px;
            box-sizing: border-box; /* Pastikan padding dihitung dalam width */
            font-family: Arial, sans-serif;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); /* Bayangan ke kiri */
        }

        .aside-admin h3 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .aside-admin p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .aside-admin ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .aside-admin li {
            margin-bottom: 15px;
        }

        .aside-admin a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            background-color: #34495e;
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
        }

        .aside-admin a:hover {
            background-color: #2c3e50;
            color: #fff;
        }

        /* Footer */
        footer {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            position: relative;
            bottom: 0;
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

            .aside-admin {
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
            .aside-admin {
                width: 100%;
                border: none;
                padding: 15px;
            }

            main {
                flex-direction: column; /* Menyusun elemen secara vertikal */
            }

            .aside-admin {
                margin-top: 20px; /* Memberi jarak atas aside */
            }
        }
    </style>
</head> 
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <?php include '../includes/nav_admin.php'; ?>
        <section class="content">
            <h2>Selamat Datang, Admin</h2>
            <p>Ini adalah halaman dashboard admin.</p>
            <!-- Konten lainnya -->
        </section>
        <?php include '../includes/aside_admin.php'; ?>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
