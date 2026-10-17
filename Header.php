<?php
require_once __DIR__ . '/config.php';
// Đường dẫn gốc: trang trong thư mục con (vd: admin/) cần thêm "../"
$base = (realpath(dirname($_SERVER['SCRIPT_FILENAME'])) === realpath(__DIR__)) ? '' : '../';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'ShoeStore') ?></title>
    <link rel="stylesheet" href="<?= $base ?>style.css">
</head>
<body>
<header class="topbar">
    <div class="container nav">
        <a class="logo" href="<?= $base ?>index.php">Shoe<span>Store</span></a>
        <nav>
            <a href="<?= $base ?>index.php">Trang chủ</a>
            <a href="<?= $base ?>index.php#products">Sản phẩm</a>
            <a href="<?= $base ?>category.php">Danh mục</a>
            <?php if (isAdmin()): ?><a href="<?= $base ?>admin/index.php">Quản trị</a><?php endif; ?>
        </nav>
        <div class="nav-right">
            <?php if (isLoggedIn()): ?>
                <span class="welcome">Xin chào, <?= e($_SESSION['user']['name']) ?></span>
                <a href="<?= $base ?>logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="<?= $base ?>login.php">Đăng nhập</a>
                <a href="<?= $base ?>register.php">Đăng ký</a>
            <?php endif; ?>
            <a class="cart" href="<?= $base ?>Giohang.php">🛒 Giỏ hàng <b><?= cartCount() ?></b></a>
        </div>
    </div>
</header>
<main class="container">