<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['qty'] ?? [] as $id => $qty) {
        $id = (int)$id; $qty = max(0, (int)$qty);
        if ($qty === 0) unset($_SESSION['cart'][$id]);
        else $_SESSION['cart'][$id] = $qty;
    }
}
$items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $marks = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($marks)");
    $stmt->execute($ids);
    foreach ($stmt as $p) {
        $p['qty'] = $_SESSION['cart'][$p['id']];
        $p['subtotal'] = $p['qty'] * $p['price'];
        $total += $p['subtotal'];
        $items[] = $p;
    }
}
$pageTitle = 'Giỏ hàng';
include 'Header.php';
?>
<div class="section">
<h1>Giỏ hàng</h1>
<?php if (!$items): ?>
    <div class="empty">Giỏ hàng đang trống. <a href="index.php">Mua sắm ngay</a></div>
<?php else: ?>
<form method="post">
<div class="cart-table">
<?php foreach ($items as $p): ?>
    <div class="cart-row">
        <img src="<?= e($p['image_url']) ?>" alt="">
        <div><b><?= e($p['name']) ?></b><small><?= number_format($p['price'],0,',','.') ?> đ</small></div>
        <input type="number" name="qty[<?= $p['id'] ?>]" value="<?= $p['qty'] ?>" min="0" max="<?= $p['stock'] ?>">
        <strong><?= number_format($p['subtotal'],0,',','.') ?> đ</strong>
        <a href="remove_cart.php?id=<?= $p['id'] ?>">Xóa</a>
    </div>
<?php endforeach; ?>
</div>
<div class="cart-summary">
    <b>Tổng: <?= number_format($total,0,',','.') ?> đ</b>
    <div><button class="btn secondary" name="update">Cập nhật</button> <a class="btn" href="ThanhToan.php">Thanh toán</a></div>
</div>
</form>
<?php endif; ?>
</div>
<?php include 'Footer.php'; ?>