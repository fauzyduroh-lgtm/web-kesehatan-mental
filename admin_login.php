<?php
session_start();
// Pastikan path koneksi benar ke folder web-mental
require "../web-mental/koneksi.php";

$pesan = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_assoc($query);

    if ($admin) {
        // Jika kamu menggunakan password_hash saat register, gunakan password_verify
        if (password_verify($password, $admin['password'])) {
            
            // SESUAIKAN: Gunakan $_SESSION['login'] agar sinkron dengan file admin lainnya
            $_SESSION['login'] = true;
            $_SESSION['user_admin'] = $admin['username']; 
            
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $pesan = "Password salah!";
        }
    } else {
        $pesan = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Mental Health</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            margin:0; height:100vh; display:flex; justify-content:center; align-items:center; 
            background: linear-gradient(135deg, #4FA3A5, #9face6); 
            font-family: 'Poppins', sans-serif; 
        }
        .card { 
            background:#fff; width:360px; padding:40px; border-radius:20px; 
            box-shadow:0 15px 35px rgba(0,0,0,0.1); 
        }
        h2 { text-align:center; color:#4FA3A5; margin-bottom: 30px; }
        input { 
            width:100%; padding:12px; margin-bottom:15px; border-radius:10px; 
            border:1px solid #ddd; box-sizing: border-box; 
        }
        button { 
            width:100%; padding:12px; border:none; border-radius:10px; 
            background:#4FA3A5; color:white; font-size:16px; font-weight:600; cursor:pointer;
        }
        button:hover { background: #3d8183; }
        .alert { 
            background:#ffebee; color:#c62828; padding:12px; border-radius:10px; 
            margin-bottom:20px; text-align:center; font-size: 14px;
        }
        .register-link { text-align:center; margin-top: 20px; font-size: 14px; }
        .register-link a { color: #4FA3A5; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="card">
   <h2>Login Admin <br><span style="font-size: 14px;">RSUD dr. Soedirman Kebumen</span></h2> 

    <?php if ($pesan != ""): ?>
        <div class="alert"><?= $pesan; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username Admin" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Masuk ke Dashboard</button>
    </form>
    
    <div class="register-link">
        Belum punya akun? <a href="register.php">Daftar di sini</a>
    </div>
</div>

</body>
</html>