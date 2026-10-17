<?php
session_start();

$host = "localhost";
$dbname = "quan_ly_ban_giay";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Không kết nối được MySQL. Hãy kiểm tra XAMPP và database quan_ly_ban_giay.");
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function cartCount() {
    return array_sum($_SESSION['cart'] ?? []);
}

function cartTotal(PDO $pdo) {
    if (empty($_SESSION['cart'])) return 0;
    $ids = array_keys($_SESSION['cart']);
    $marks = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($marks)");
    $stmt->execute($ids);
    $total = 0;
    foreach ($stmt as $p) {
        $total += $p['price'] * ($_SESSION['cart'][$p['id']] ?? 0);
    }
    return $total;
}
?>