<?php
/**
 * Login Page
 * Handling User Logic with Password Verification using PDO
 */

if (is_logged_in()) {
    header("Location: ?route=creator/dashboard");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic Validation
    if (empty($email) || empty($password)) {
        $error = "Plese fill in all fields.";
    } else {
        // Find user by email or username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Success - Set Sessions
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'creator') {
                header("Location: ?route=creator/dashboard");
            } else {
                header("Location: ?route=home");
            }
            exit();
        } else {
            $error = "Email/Username atau Password salah.";
        }
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
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f4f4; margin: 0; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { margin-top: 0; color: #333; text-align: center; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; color: #666; font-size: 0.9rem;}
        input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #007bff; color: white; border: none; padding: 0.75rem; border-radius: 4px; width: 100%; cursor: pointer; font-size: 1rem; margin-top: 1rem; }
        button:hover { background-color: #0056b3; }
        .error { color: #dc3545; background: #f8d7da; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.85rem;}
        .footer-link { text-align: center; margin-top: 1.5rem; font-size: 0.9rem;}
        a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email atau Username</label>
                <input type="text" name="email" required placeholder="User_123 / example@email.com">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="********">
            </div>
            <button type="submit">Login</button>
        </form>
        
        <div class="footer-link">
            Belum punya akun? <a href="?route=auth/register">Daftar di sini</a>
            <br><br>
            <a href="?route=home" style="color: #666;">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
