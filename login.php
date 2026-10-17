<?php
require_once 'config.php';
if (isLoggedIn()) { header("Location: index.php"); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = $user;
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        header("Location: index.php"); exit;
    }
    $error = 'Email hoặc mật khẩu không đúng.';
}
$pageTitle = 'Đăng nhập';
include 'Header.php';
?>
<div class="auth-card">
    <h1>Đăng nhập</h1>
    <?php if (isset($_GET['registered'])): ?><div class="alert success">Đăng ký thành công. Hãy đăng nhập.</div><?php endif; ?>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <label>Email<input type="email" name="email" required></label>
        <label>Mật khẩu<input type="password" name="password" required></label>
        <button class="btn full">Đăng nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</div>
<?php include 'Footer.php'; ?>