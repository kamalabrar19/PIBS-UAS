<?php
// login.php
require 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengecek username dan password
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header('Location: admin/index.php');
        } else {
            header('Location: user/index.php');
        }
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inex Mail</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 85%;
            max-width: 1200px;
            height: 700px;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .left {
            flex: 1.5;
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            text-align: center;
        }

        .left h1 {
            font-size: 40px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .left p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .left img {
            width: 250px;
            margin-top: 20px;
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            color: #555;
        }

        .form-container input {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease-in-out;
        }

        .form-container input:focus {
            border-color: #2575fc;
            outline: none;
        }

        .form-container button {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .form-container button:hover {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
        }

        .form-container .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .left, .right {
                flex: none;
                width: 100%;
            }

            .left {
                padding: 30px;
            }

            .right {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bagian Kiri -->
        <div class="left">
            <h1>Inex Mail</h1>
            <p>Mengelola surat internal dan eksternal perusahaan Anda dengan cepat, aman, dan efisien. Bergabunglah dengan platform kami untuk pengalaman terbaik dalam mengatur dokumen Anda.</p>
            <img src="assets/fotoGrup.jpeg" alt="foto-grup">
        </div>

        <!-- Bagian Kanan -->
        <div class="right">
            <div class="form-container">
                <h2>Login</h2>
                <?php if(isset($error)): ?>
                    <p class="error"><?= $error ?></p>
                <?php endif; ?>
                <form method="POST" action="">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                    <button type="submit" name="login">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
