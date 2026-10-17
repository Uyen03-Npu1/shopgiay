<?php
require_once 'config.php';
if (!isLoggedIn()) { header("Location: login.php"); exit; }
if (empty($_SESSION['cart'])) { header("Location: Giohang.php"); exit; }

$ids = array_keys($_SESSION['cart']);
$marks = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($marks)");
$stmt->execute($ids);
$items = $stmt->fetchAll();
$total = 0;
foreach ($items as $p) $total += $p['price'] * $_SESSION['cart'][$p['id']];

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($address === '' || $phone === '') {
        $error = 'Vui lòng nhập địa chỉ và số điện thoại.';
    } else {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO orders(user_id,total_amount,address,phone,status) VALUES(?,?,?,?, 'pending')");
            $stmt->execute([$_SESSION['user']['id'],$total,$address,$phone]);
            $orderId = $pdo->lastInsertId();
            $detail = $pdo->prepare("INSERT INTO order_details(order_id,product_id,quantity,price) VALUES(?,?,?,?)");
            foreach ($items as $p) {
                $qty = $_SESSION['cart'][$p['id']];
                if ($qty > $p['stock']) throw new Exception('Sản phẩm không đủ số lượng.');
                $detail->execute([$orderId,$p['id'],$qty,$p['price']]);
                $pdo->prepare("UPDATE products SET stock=stock-? WHERE id=?")->execute([$qty,$p['id']]);
            }
            $pdo->commit();
            $_SESSION['cart'] = [];
            header("Location: ThanhToan.php?success=1&order=".$orderId); exit;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $error = $e->getMessage();
        }
    }
}
$pageTitle = 'Thanh toán';
include 'Header.php';
?>
<div class="checkout">
<?php if (isset($_GET['success'])): ?>
    <div class="alert success">Đặt hàng thành công! Mã đơn hàng #<?= (int)$_GET['order'] ?>.</div>
    <a class="btn" href="index.php">Tiếp tục mua hàng</a>
<?php else: ?>
<h1>Thanh toán</h1>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="checkout-form">
    <label>Địa chỉ nhận hàng<textarea name="address" required></textarea></label>
    <label>Số điện thoại<input name="phone" required></label>
    <div class="order-box">
        <?php foreach ($items as $p): ?><p><?= e($p['name']) ?> × <?= $_SESSION['cart'][$p['id']] ?> <b><?= number_format($p['price']*$_SESSION['cart'][$p['id']],0,',','.') ?> đ</b></p><?php endforeach; ?>
        <hr><h2><?= number_format($total,0,',','.') ?> đ</h2>
    </div>
    <button class="btn full">Đặt hàng</button>
</form>
<?php endif; ?>
</div>
<?php include 'Footer.php'; ?>