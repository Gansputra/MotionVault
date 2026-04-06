<?php
/**
 * Creator Dashboard
 */

// Middleware: Hanya bisa diakses oleh kreator yang sudah login
require_role('creator');

$userName = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kreator - MotionVault</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f8f9fa; }
        .sidebar { position: fixed; left: 0; top: 0; bottom: 0; width: 240px; background-color: #343a40; color: white; padding-top: 1.5rem; }
        .sidebar-brand { padding: 0 1.5rem 2rem; font-size: 1.25rem; font-weight: bold; border-bottom: 1px solid #454d55; }
        .sidebar-menu { list-style: none; padding: 1rem 0; margin: 0; }
        .sidebar-menu li a { display: block; padding: 0.75rem 1.5rem; color: #ced4da; text-decoration: none; transition: background 0.3s; }
        .sidebar-menu li a:hover { background-color: #495057; color: white; }
        .main-content { margin-left: 240px; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .welcome-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h1, h2 { color: #333; margin-top: 0; }
        .btn-logout { color: #dc3545; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">MotionVault</div>
        <ul class="sidebar-menu">
            <li><a href="?route=creator/dashboard" class="active">🏠 Dashboard</a></li>
            <li><a href="?route=creator/my-assets">📁 My Assets</a></li>
            <li><a href="?route=creator/upload">📤 Upload Asset</a></li>
            <li><a href="?route=creator/settings">⚙️ Settings</a></li>
            <li><a href="?route=auth/logout" class="btn-logout">🚪 Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header class="header">
            <div>
                <h1>Dashboard</h1>
                <p>Hello, <strong><?php echo htmlspecialchars($userName); ?></strong>! Selamat datang di MotionVault.</p>
            </div>
            <div>
                 <a href="?route=auth/logout" style="color: #6c757d; text-decoration: none;">🚪 Logout</a>
            </div>
        </header>

        <section class="welcome-card">
            <h2>Ringkasan Akun</h2>
            <p>Ini adalah halaman utama dashboard untuk para kreator di MotionVault.</p>
            <ul>
                <li>Total Assets: 0</li>
                <li>Total Earnings: $0.00</li>
                <li>Followers: 0</li>
            </ul>
        </section>
    </div>
</body>
</html>
