<?php
include 'config.php';
echo "<h2>Root pvc.db Orders:</h2>";
$count = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
echo "Total orders: $count<br>";
$stmt = $pdo->query("SELECT id, doc_type, full_name, status, created_at FROM orders ORDER BY id DESC LIMIT 3");
echo "<pre>" . print_r($stmt->fetchAll(), true) . "</pre>";

$admin_db = 'admin/pvc.db';
try {
$pdo_admin = new PDO('sqlite:' . $admin_db);
$count_admin = $pdo_admin->query("SELECT COUNT(*) FROM orders")->fetchColumn();
echo "<h2>Admin pvc.db Orders:</h2>";
echo "Total orders: $count_admin<br>";
$stmt_admin = $pdo_admin->query("SELECT id, doc_type, full_name, status FROM orders ORDER BY id DESC LIMIT 3");
echo "<pre>" . print_r($stmt_admin->fetchAll(), true) . "</pre>";
} catch (Exception $e) {
echo "Admin DB error: " . $e->getMessage();
}
?>
<a href='admin/login.php'>Admin Login</a>
