<?php
require_once 'config.php';
if (isLoggedIn()) { header("Location: index.php"); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = 'Vui lòng nhập đủ thông tin và mật khẩu từ 6 ký tự.';
    } elseif ($password !== $confirm) {
        $error = 'Mật khẩu nhập lại không khớp.';
    } else {
        $check = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = 'Email đã được đăng ký.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,'customer')");
            $stmt->execute([$name,$email,$hash]);
            header("Location: login.php?registered=1"); exit;
        }
    }
}
$pageTitle = 'Đăng ký';
include 'Header.php';
?>
<div class="auth-card">
    <h1>Tạo tài khoản</h1>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <label>Họ tên<input name="name" required></label>
        <label>Email<input type="email" name="email" required></label>
        <label>Mật khẩu<input type="password" name="password" required></label>
        <label>Nhập lại mật khẩu<input type="password" name="confirm" required></label>
        <button class="btn full">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</div>
<?php include 'Footer.php'; ?>