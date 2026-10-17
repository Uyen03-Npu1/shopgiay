<?php
require_once 'config.php';
$id = (int)($_GET['id'] ?? 0);
unset($_SESSION['cart'][$id]);
header("Location: Giohang.php");
exit;
?>