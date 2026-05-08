<?php
include 'config.php';

echo "<h1>🚀 Complete Demo Seeder (Fixed) 🚀</h1>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;background:#f8f9fa;border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,0.1);}h1{color:#28a745;}.success{color:#155724;background:#d4edda;padding:15px;border-radius:8px;margin:20px 0;}.error{color:#dc3545;background:#f8d7da;padding:15px;border-radius:8px;margin:20px 0;}</style>";

// Demo Customers
echo "<h2>1. Adding Demo Customers...</h2>";
$demo_customers = [
    ['order.demo1@gmail.com', '9876543210', password_hash('pass123', PASSWORD_DEFAULT)],
    ['order.demo2@gmail.com', '9876543211', password_hash('pass456', PASSWORD_DEFAULT)],
    ['order.demo3@gmail.com', '9876543212', password_hash('testpass', PASSWORD_DEFAULT)]
];
$customer_count = 0;
foreach ($demo_customers as $data) {
    try {
        $stmt = $pdo->prepare("INSERT OR IGNORE INTO customers (email, mobile, password) VALUES (?, ?, ?)");
        $stmt->execute($data);
        $customer_count++;
    } catch (Exception $e) {
        echo "<div class='error'>Skipped {$data[0]}: {$e->getMessage()}</div>";
    }
}
echo "<div class='success'>✅ $customer_count Demo Customers Added</div>";

// Demo Orders (nullable customer_id)
echo "<h2>2. Adding Demo Orders...</h2>";
$demo_orders = [
    ['Aadhar Card', 'John Doe', '9876543210', '123 Main St, Bhubaneswar', 'Bhubaneswar', 'Odisha', '751001', 150.00, NULL, 'Pending', '[]'],
    ['PAN Card', 'Jane Smith', '9876543211', '456 Park Ave, Cuttack', 'Cuttack', 'Odisha', '753001', 200.00, NULL, 'Processing', '[]'],
    ['Driving License', 'Test User', '9876543212', '789 Hill Rd, Puri', 'Puri', 'Odisha', '752001', 250.00, NULL, 'Ready', '[]'],
    ['Ration Card', 'Demo Customer', '9876543210', '321 Sea View, Paradip', 'Paradip', 'Odisha', '754142', 100.00, NULL, 'Pickup', '[]']
];

$stmt_order = $pdo->prepare("INSERT INTO orders (doc_type, full_name, mobile, address, city, state, pincode, price, customer_id, status, files_json) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$order_count = 0;
foreach ($demo_orders as $order) {
    try {
        $stmt_order->execute($order);
        $order_count++;
    } catch (Exception $e) {
        echo "<div class='error'>Order error: {$e->getMessage()}</div>";
    }
}
echo "<div class='success'>✅ $order_count Demo Orders Added</div>";

// Admin
echo "<h2>3. Admin Account...</h2>";
try {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);
    echo "<div class='success'>✅ Admin: <strong>admin / admin123</strong></div>";
} catch (Exception $e) {
    echo "<div class='error'>Admin error: {$e->getMessage()}</div>";
}

// Final Stats
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$total_customers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
echo "<div class='success'><h3>📊 Final Stats:</h3>
<p>Orders: <strong>$total_orders</strong> | Customers: <strong>$total_customers</strong></p>
</div>";

echo '<div style="display:flex; gap:15px; flex-wrap:wrap; margin-top:30px;">';
echo '<a href="admin/dashboard.php" style="background:#007bff;color:white;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;">Dashboard →</a>';
echo '<a href="admin/orders.php" style="background:#28a745;color:white;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;">Orders →</a>';
echo '<a href="admin/customers.php" style="background:#ffc107;color:#000;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;">Customers →</a>';
echo '</div>';
echo '<p style="margin-top:20px;"><a href="index.php" style="color:#6c757d;">← Back Home</a></p>';
?>

