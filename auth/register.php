<?php
/**
 * Register Page
 * Handling User Registration with Password Hashing
 */

if (is_logged_in()) {
    header("Location: ?route=creator/dashboard");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // From dropdown

    // Basic Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua field wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        // Check if username/email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->fetch()) {
            $error = "Username atau Email sudah terdaftar.";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert User
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            try {
                $stmt->execute([$username, $email, $hashedPassword, $role]);
                $success = "Registrasi berhasil! Silakan <a href='?route=auth/login'>Login</a>.";
            } catch (PDOException $e) {
                $error = "Terjadi kesalahan sistem: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MotionVault</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f4; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { margin-top: 0; color: #333; text-align: center; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.4rem; color: #666; font-size: 0.9rem;}
        input, select { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; border: none; padding: 0.75rem; border-radius: 4px; width: 100%; cursor: pointer; font-size: 1rem; margin-top: 1rem;}
        button:hover { background-color: #218838; }
        .error { color: #dc3545; background: #f8d7da; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.85rem;}
        .success { color: #155724; background: #d4edda; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.85rem;}
        .footer-link { text-align: center; margin-top: 1.5rem; font-size: 0.9rem;}
        a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Daftar Akun Baru</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="User_123">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="email@example.com">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="minimal 6 karakter">
            </div>
            <div class="form-group">
                <label>Saya mendaftar sebagai:</label>
                <select name="role">
                    <option value="customer">Buyer (Beli Asset)</option>
                    <option value="creator">Creator (Jual Asset)</option>
                </select>
            </div>
            <button type="submit">Daftar Sekarang</button>
        </form>
        
        <div class="footer-link">
            Sudah punya akun? <a href="?route=auth/login">Login di sini</a>
            <br><br>
            <a href="?route=home" style="color: #666;">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
