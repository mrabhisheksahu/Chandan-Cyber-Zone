<?php
include 'config.php';

// Clear existing demo data (optional)
// $pdo->exec("DELETE FROM customers WHERE email LIKE 'demo%' OR mobile LIKE '987654%'");

// Insert demo customers
$demo_customers = [
    ['john.doe@example.com', '9876543210', password_hash('pass123', PASSWORD_DEFAULT), 'John Doe'],
    ['jane.smith@gmail.com', '9876543211', password_hash('pass456', PASSWORD_DEFAULT), 'Jane Smith'],
    ['test.user@test.com', '9876543212', password_hash('testpass', PASSWORD_DEFAULT), 'Test User']
];

foreach ($demo_customers as $c) {
$stmt = $pdo->prepare("INSERT OR IGNORE INTO customers (email, mobile, password, created_at) VALUES (?, ?, ?, datetime('now', '-? days'))");
$stmt->execute([$c[0], $c[1], $c[2], rand(0, 7)]);
}

// Ensure admin exists
$stmt = $pdo->prepare("INSERT OR IGNORE INTO admins (username, password) VALUES (?, ?)");
$stmt->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);

$count_customers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$count_admins = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();

echo "<h1>Demo Data Seeded Successfully! ✅</h1>";
echo "<p><strong>Customers:</strong> $count_customers total</p>";
echo "<p><strong>Admin:</strong> admin / admin123</p>";
echo "<p><a href='admin/customers.php'>View Customers in Admin Panel</a> | <a href='index.php'>Home</a></p>";
echo "<script>alert('Demo data added! Check admin/customers.php');</script>";
?>

