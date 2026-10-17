<?php
require_once 'config.php';
$pageTitle = 'ShoeStore - Cửa hàng giày';
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$products = $pdo->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC")->fetchAll();
include 'Header.php';
?>
<section class="hero">
    <div>
        <p class="eyebrow">SHOESTORE 2026</p>
        <h1>Giày đẹp cho mọi phong cách.</h1>
        <p>Khám phá sneaker, running và giày thời trang với giao diện bán hàng đầy đủ.</p>
        <a class="btn" href="#products">Mua ngay</a>
    </div>
    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=85" alt="Giày sneaker">
</section>

<section class="section">
    <div class="section-head">
        <h2>Danh mục</h2>
        <a href="category.php">Xem tất cả</a>
    </div>
    <div class="category-grid">
        <?php foreach ($categories as $c): ?>
            <a class="category-card" href="category.php?id=<?= (int)$c['id'] ?>">
                <span>👟</span><strong><?= e($c['name']) ?></strong>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="section" id="products">
    <div class="section-head">
        <h2>Sản phẩm mới</h2>
        <span><?= count($products) ?> sản phẩm</span>
    </div>
    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <article class="product-card">
                <a href="product.php?id=<?= (int)$p['id'] ?>">
                    <img src="<?= e($p['image_url']) ?>" alt="<?= e($p['name']) ?>">
                </a>
                <div class="product-info">
                    <small><?= e($p['category_name']) ?></small>
                    <h3><?= e($p['name']) ?></h3>
                    <div class="price"><?= number_format($p['price'], 0, ',', '.') ?> đ</div>
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button class="btn btn-small" type="submit">Thêm vào giỏ</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php include 'Footer.php'; ?>