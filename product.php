<?php
require_once 'config.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) { header("Location: index.php"); exit; }
$pageTitle = $product['name'];
include 'Header.php';
?>
<div class="detail">
    <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>">
    <div>
        <small><?= e($product['category_name']) ?></small>
        <h1><?= e($product['name']) ?></h1>
        <div class="price big"><?= number_format($product['price'],0,',','.') ?> đ</div>
        <p><?= nl2br(e($product['description'])) ?></p>
        <p><b>Còn lại:</b> <?= (int)$product['stock'] ?> đôi</p>
        <form action="add_to_cart.php" method="post" class="buy-form">
            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
            <input type="number" name="quantity" value="1" min="1" max="<?= (int)$product['stock'] ?>">
            <button class="btn" type="submit">Thêm vào giỏ</button>
        </form>
    </div>
</div>
<?php include 'Footer.php'; ?>