<?php
require_once 'config.php';
$id = (int)($_GET['id'] ?? 0);
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
if ($id) {
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id=c.id WHERE c.id=? ORDER BY p.id DESC");
    $stmt->execute([$id]);
    $products = $stmt->fetchAll();
} else {
    $products = $pdo->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC")->fetchAll();
}
$pageTitle = 'Danh mục sản phẩm';
include 'Header.php';
?>
<div class="section">
    <div class="section-head"><h2>Danh mục sản phẩm</h2></div>
    <div class="chips">
        <a href="category.php">Tất cả</a>
        <?php foreach ($categories as $c): ?><a href="category.php?id=<?= $c['id'] ?>"><?= e($c['name']) ?></a><?php endforeach; ?>
    </div>
    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <article class="product-card">
                <a href="product.php?id=<?= $p['id'] ?>"><img src="<?= e($p['image_url']) ?>" alt="<?= e($p['name']) ?>"></a>
                <div class="product-info">
                    <small><?= e($p['category_name']) ?></small>
                    <h3><?= e($p['name']) ?></h3>
                    <div class="price"><?= number_format($p['price'],0,',','.') ?> đ</div>
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <button class="btn btn-small">Thêm vào giỏ</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'Footer.php'; ?>