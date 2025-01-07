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
    <!-- CSS Inline -->
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
            min-height: 80vh;
        }

        /* Nav di Kiri (25%) */
        .side-nav {
            width: 25%;
            background-color: #fff;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .side-nav ul {
            list-style: none;
        }

        .side-nav ul li {
            margin-bottom: 15px;
        }

        .side-nav ul li a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
        }

        .side-nav ul li a:hover {
            color: #007BFF;
        }

        /* Konten di Tengah (50%) */
        .content {
            width: 50%;
            padding: 20px;
        }

        .content h2 {
            margin-bottom: 15px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #555;
        }

        /* Aside di Kanan (25%) */
        .aside {
            width: 25%;
            background-color: #fff;
            padding: 20px;
            border-left: 1px solid #ddd;
        }

        .aside h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .aside p {
            font-size: 14px;
            color: #555;
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

        /* Responsive */
        @media (max-width: 768px) {
            main {
                flex-direction: column;
            }

            .side-nav, .aside {
                width: 100%;
                border: none;
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
