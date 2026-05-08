<?php
include 'config.php';

echo "<h1>🔥 FINAL Demo Seeder - All Fixed 🔥</h1>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;background:#f8f9fa;border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,0.1);}h1{color:#dc3545;font-size:2em;}.success{color:#155724;background:#d4edda;padding:15px;border-radius:8px;margin:20px 0;}.btn{display:inline-block;padding:12px 24px;background:#28a745;color:white;text-decoration:none;border-radius:8px;font-weight:bold;}</style>";

// 1. Demo Customers
echo "<h2>📧 Adding Customers...</h2>";
try {
    $customers = [
        ['customer1@test.com', '9876543210', password_hash('pass1', PASSWORD_DEFAULT)],
        ['customer2@test.com', '9876543211', password_hash('pass2', PASSWORD_DEFAULT)],
        ['customer3@test.com', '9876543212', password_hash('pass3', PASSWORD_DEFAULT)]
    ];
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO customers (email, mobile, password) VALUES (?, ?, ?)");
    foreach ($customers as $c) $stmt->execute($c);
    echo "<div class='success'>✅ 3 Customers Added</div>";
} catch (Exception $e) { echo "<div class='error'>Customer error: " . $e->getMessage() . "</div>"; }

// 2. Demo Orders (exclude customer_id to match schema)
echo "<h2>📦 Adding Orders...</h2>";
try {
    $orders = [
        ['Aadhar Card', 'John Doe', '9876543210', '123 St', 'City1', 'State1', '12345', 150.0, 'Pending', '[]'],
        ['PAN Card', 'Jane Doe', '9876543211', '456 Ave', 'City2', 'State2', '67890', 200.0, 'Processing', '[]'],
        ['DL', 'Test User', '9876543212', '789 Rd', 'City3', 'State3', '11111', 250.0, 'Ready', '[]']
    ];
    $stmt = $pdo->prepare("INSERT INTO orders (doc_type, full_name, mobile, address, city, state, pincode, price, status, files_json) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($orders as $o) $stmt->execute($o);
    echo "<div class='success'>✅ 3 Orders Added (Pending/Processing/Ready)</div>";
} catch (Exception $e) { echo "<div class='error'>Order error: " . $e->getMessage() . "</div>"; }

// 3. Admin
echo "<h2>👨‍💼 Admin Setup...</h2>";
try {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);
    echo "<div class='success'>✅ Admin: <strong>admin/admin123</strong></div>";
} catch (Exception $e) { echo "<div class='error'>Admin error</div>"; }

// Stats
try {
    $c = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
    $o = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    echo "<div class='success'><h3>📊 Stats: $c Customers | $o Orders</h3></div>";
} catch (Exception $e) {}

echo '<p style="margin-top:40px;">';
echo '<a href="admin/dashboard.php" class="btn">Dashboard</a> ';
echo '<a href="admin/orders.php" class="btn">Orders</a> ';
echo '<a href="admin/customers.php" class="btn">Customers</a>';
echo '</p><p><a href="index.php">🏠 Home</a></p>';
?>

