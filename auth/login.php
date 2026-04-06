<?php
/**
 * Login Page
 */

// Basic Session Check (if already logged in, redirect to creator)
if (isset($_SESSION['user_id'])) {
    header("Location: ?route=creator/dashboard");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic Handling for dummy login
    $email = $_POST['email'];
    $password = $_POST['password'];

    // This is where you would database-authenticate your user with $pdo
    // Example: $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    // $stmt->execute([$email]);
    // $user = $stmt->fetch();
    
    // For demonstration, only check non-empty fields
    if (!empty($email) && !empty($password)) {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = 'MotionVault Creator';
        header("Location: ?route=creator/dashboard");
        exit();
    } else {
        $error = "Plese fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MotionVault</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; margin: 0; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; color: #666; }
        input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; padding: 0.75rem; border-radius: 4px; width: 100%; cursor: pointer; font-size: 1rem; }
        button:hover { background-color: #0056b3; }
        .error { color: #dc3545; font-size: 0.875rem; margin-bottom: 1rem; }
        .footer-link { text-align: center; margin-top: 1rem; }
        a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="footer-link">
            Belum punya akun? <a href="?route=auth/register">Daftar di sini</a>
            <br>
            <a href="?route=home">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
