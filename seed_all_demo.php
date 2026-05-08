<?php
include 'config.php';

echo "<h1>🌟 Full Demo Data Seeder 🌟</h1>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;background:#f8f9fa;border-radius:10px;}h1{color:#28a745;}.success{color:#155724;background:#d4edda;padding:15px;border-radius:8px;margin:20px 0;}</style>";

// 1. Demo Customers (already handled)
$stmt = $pdo->prepare("INSERT OR IGNORE INTO customers (email, mobile, password, created_at) VALUES (?, ?, ?, datetime('now'))");
$customers = [
    ['order.demo1@gmail.com', '9876543210', password_hash('pass123', PASSWORD_DEFAULT)],
    ['order.demo2@gmail.com', '9876543211', password_hash('pass456', PASSWORD_DEFAULT)],
    ['order.demo3@gmail.com', '9876543212', password_hash('testpass', PASSWORD_DEFAULT)]
];
foreach ($customers as $c) {
    $stmt->execute($c);
}
echo "<div class='success'>✅ 3 Demo Customers Added</div>";

// 2. Demo Orders
$demo_orders = [
    ['Aadhar Card', 'John Doe', '9876543210', '123 Main St', 'Bhubaneswar', 'Odisha', '751001', 150.00, 1, 'Pending', json_encode([])],
    ['PAN Card', 'Jane Smith', '9876543211', '456 Park Ave', 'Cuttack', 'Odisha', '753001', 200.00, 2, 'Processing', json_encode([])],
    ['Driving License', 'Test User', '9876543212', '789 Hill Rd', 'Puri', 'Odisha', '752001', 250.00, 3, 'Ready', json_encode([])],
    ['Ration Card', 'Demo User', '9876543213', '321 Sea View', 'Paradip', 'Odisha', '754142', 100.00, 1, 'Pickup', json_encode([])]
];

$stmt_order = $pdo->prepare("INSERT INTO orders (doc_type, full_name, mobile, address, city, state, pincode, price, customer_id, status, files_json) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($demo_orders as $order) {
    $stmt_order->execute($order);
}
echo "<div class='success'>✅ 4 Demo Orders Added (Various statuses)</div>";

// 3. Admin
$stmt_admin = $pdo->prepare("INSERT OR IGNORE INTO admins (username, password) VALUES (?, ?)");
$stmt_admin->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);
echo "<div class='success'>✅ Admin Account: admin / admin123</div>";

// Stats
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$total_customers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
echo "<div class='success'><strong>Stats:</strong> {$total_orders} Orders | {$total_customers} Customers</div>";

echo '<p><a href="admin/dashboard.php" style="background:#007bff;color:white;padding:12px 24px;display:inline-block;border-radius:6px;">→ Admin Dashboard</a> ';
echo '<a href="admin/orders.php" style="background:#28a745;color:white;padding:12px 24px;display:inline-block;border-radius:6px;">→ Orders</a> ';
echo '<a href="admin/customers.php" style="background:#ffc107;color:#111;padding:12px 24px;display:inline-block;border-radius:6px;">→ Customers</a></p>';
echo '<p><a href="index.php">← Home</a></p>';
?>

