<?php
// admin/index.php
require_once '../config.php';

// Cek apakah user sudah login dan role-nya 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
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
            color: #333;
        }

        /* Header */
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

        .logo img {
            max-width: 50px;
            height: auto;
            margin-right: 15px;
        }

        .site-info {
            display: flex;
            flex-direction: column;
        }

        .site-info h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .site-info p {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
        }

        footer {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
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
            transition: color 0.3s;
        }

        .side-nav ul li a:hover {
            color: #007bff;
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
        <?php include '../includes/nav_user.php'; ?>
        <section class="content">
            <h2>Selamat Datang, User</h2>
            <p>Ini adalah halaman dashboard user.</p>
            <!-- Konten lainnya -->
        </section>
        <?php include '../includes/aside_user.php'; ?>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
