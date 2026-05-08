<?php
include 'config.php';

echo "<h1>🛠️ Orders Table Fix & Demo Data</h1>";
echo "<style>body{font-family:sans-serif;max-width:700px;margin:50px auto;padding:20px;}.success{background:#d4edda;color:#155724;padding:15px;border-radius:8px;margin:20px 0;}.error{background:#f8d4da;color:#721c24;padding:15px;border-radius:8px;margin:20px 0;}.btn{display:inline-block;padding:10px 20px;background:#007bff;color:white;border-radius:5px;text-decoration:none;font-weight:bold;}</style>";

// Check current orders schema
$info = $pdo->query("PRAGMA table_info(orders)")->fetchAll();
$has_customer_id = false;
foreach ($info as $col) if ($col['name'] == 'customer_id') $has_customer_id = true;

if (!$has_customer_id) {
    try {
        $pdo->exec("ALTER TABLE orders ADD COLUMN customer_id INTEGER");
        echo "<div class='success'>✅ Added customer_id column to orders</div>";
    } catch (Exception $e) {
        echo "<div class='error'>ALTER failed (may exist): " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='success'>✅ customer_id column exists</div>";
}

// Clear old demo orders
$pdo->exec("DELETE FROM orders WHERE doc_type IN ('Aadhar Card', 'PAN Card', 'DL') OR full_name LIKE '%Doe%'");

// Insert demo orders
$demo_orders = [
    ['Aadhar Card', 'John Doe', '9876543210', '123 Main St', 'Bhubaneswar', 'Odisha', '751001', 150.0, NULL, 'Pending', '[]'],
    ['PAN Card', 'Jane Doe', '9876543211', '456 Park Ave', 'Cuttack', 'Odisha', '753001', 200.0, NULL, 'Processing', '[]'],
    ['Driving License', 'Test User', '9876543212', '789 Hill Rd', 'Puri', 'Odisha', '752001', 250.0, NULL, 'Ready', '[]'],
    ['Ration Card', 'Demo Customer', '9876543213', '321 Sea View', 'Paradip', 'Odisha', '754142', 100.0, NULL, 'Pickup', '[]']
];

$count_inserted = 0;
$stmt = $pdo->prepare("INSERT INTO orders (doc_type, full_name, mobile, address, city, state, pincode, price, customer_id, status, files_json) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($demo_orders as $order) {
    try {
        $stmt->execute($order);
        $count_inserted++;
    } catch (Exception $e) {
        echo "<div class='error'>Insert failed: " . $e->getMessage() . "</div>";
    }
}

$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
echo "<div class='success'>✅ $count_inserted demo orders inserted. Total orders: $total_orders</div>";

echo '<p><a href="admin/orders.php" class="btn">View Orders →</a> ';
echo '<a href="admin/dashboard.php" class="btn">Dashboard →</a> ';
echo '<a href="admin/customers.php" class="btn">Customers →</a></p>';
echo '<p><a href="index.php">Home</a></p>';
?>

