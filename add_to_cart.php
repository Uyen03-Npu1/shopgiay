<?php
require_once 'config.php';
$id = (int)($_POST['product_id'] ?? 0);
$qty = max(1, (int)($_POST['quantity'] ?? 1));
$stmt = $pdo->prepare("SELECT id, stock FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if ($product) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $current = $_SESSION['cart'][$id] ?? 0;
    $_SESSION['cart'][$id] = min($product['stock'], $current + $qty);
}
$back = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: $back");
exit;
?>