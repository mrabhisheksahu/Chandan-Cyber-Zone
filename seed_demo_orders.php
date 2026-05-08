<?php
include 'config.php';
echo "<h1>🌟 Demo Data Seeder for Dashboard & Orders</h1>";
echo "<style>body{font-family:Arial;margin:40px;background:#f8f9fa;} .success{background:#d4edda;color:#155724;padding:15px;border-radius:10px;margin:20px 0;} .error{background:#ffe1e1;color:#a40000;padding:15px;border-radius:10px;} pre{ background:#f8f9fa;padding:15px;border-radius:8px;font-family:monospace;white-space:pre-wrap;max-height:300px;overflow:auto;}</style>";

// Demo Customers (3 new, safe insert)
$demo_customers = [
    ['demo1@test.com', '9876543210', password_hash('demo', PASSWORD_DEFAULT)],
    ['demo2@test.com', '9876543211', password_hash('demo', PASSWORD_DEFAULT)],
    ['demo3@test.com', '9876543212', password_hash('demo', PASSWORD_DEFAULT)]
];
try {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO customers (email, mobile, password) VALUES (?, ?, ?)");
    foreach ($demo_customers as $c) {
        $stmt->execute($c);
    }
    $customers_added = $pdo->query("SELECT COUNT(*) FROM customers WHERE email LIKE 'demo%'")->fetchColumn();
    echo "<div class='success'>✅ Added/Verified $customers_added demo customers</div>";
    
    // Fetch customer IDs
    $stmt = $pdo->query("SELECT id FROM customers ORDER BY id DESC LIMIT 3");
    $customer_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (count($customer_ids) == 0) throw new Exception('No customers in DB');
    
    // Demo Orders (10 varied)
    $demo_orders = [
        ['Aadhar', 'Rahul Sharma', '9876543210', '123 Main St', 'Delhi', 'Delhi', '110001', 100, $customer_ids[0], 'Pending'],
        ['PAN', 'Priya Singh', '9876543211', '456 Park Ave', 'Mumbai', 'Maharashtra', '400001', 80, $customer_ids[1], 'Processing'],
        ['DL', 'Amit Kumar', '9876543212', '789 Civil Lines', 'Bangalore', 'Karnataka', '560001', 120, $customer_ids[2], 'Ready'],
        ['Voter', 'Neha Patel', '9876543210', '321 MG Road', 'Pune', 'Maharashtra', '411001', 90, $customer_ids[0], 'Pickup'],
        ['RC', 'Vikram Yadav', '9876543211', '555 Sector 15', 'Chennai', 'Tamil Nadu', '600001', 150, $customer_ids[1], 'Rejected'],
        ['Aadhar', 'Sonia Gupta', '9876543212', '777 Lake View', 'Hyderabad', 'Telangana', '500001', 100, $customer_ids[2], 'Processing'],
        ['PAN', 'Rajesh Mishra', '9876543210', '999 New Town', 'Kolkata', 'West Bengal', '700001', 80, $customer_ids[0], 'Ready'],
        ['DL', 'Pooja Reddy', '9876543211', '111 Hill Side', 'Ahmedabad', 'Gujarat', '380001', 120, $customer_ids[1], 'Pending'],
        ['Health Card', 'Karan Joshi', '9876543212', '222 Valley Rd', 'Jaipur', 'Rajasthan', '302001', 200, $customer_ids[2], 'Pickup'],
        ['Ration', 'Anita Devi', '9876543210', '333 River Side', 'Lucknow', 'UP', '226001', 70, $customer_ids[0], 'Processing']
    ];
    
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO orders (doc_type, full_name, mobile, address, city, state, pincode, price, customer_id, status, files_json, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '[]', datetime('now'))");
    $inserted = 0;
    foreach ($demo_orders as $order) {
        $stmt->execute($order);
        if ($stmt->rowCount() > 0) $inserted++;
    }
    echo "<div class='success'>✅ Inserted $inserted new demo orders (Total now: " . $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn() . ")</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

// Stats preview
echo "<h3>📊 Current Dashboard Stats Preview:</h3>";
$stats = [
    'Total Orders' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'Pending' => $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Pending'")->fetchColumn(),
    'Processing' => $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Processing'")->fetchColumn(),
    'Ready' => $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Ready'")->fetchColumn(),
    'Pickup' => $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Pickup'")->fetchColumn(),
    'Rejected' => $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Rejected'")->fetchColumn()
];
echo "<pre>" . print_r($stats, true) . "</pre>";

echo "<p><a href='admin/dashboard.php' style='background:#ffd86f;color:#111;padding:12px 24px;border-radius:8px;font-weight:bold;text-decoration:none;display:inline-block;'>→ View Dashboard</a> ";
echo "<a href='admin/orders.php' style='background:#28a745;color:white;padding:12px 24px;border-radius:8px;font-weight:bold;text-decoration:none;display:inline-block;'>→ View Orders</a> ";
echo "<a href='index.php' style='background:#6c757d;color:white;padding:12px 24px;border-radius:8px;font-weight:bold;text-decoration:none;display:inline-block;'>🏠 Home</a></p>";
?>

