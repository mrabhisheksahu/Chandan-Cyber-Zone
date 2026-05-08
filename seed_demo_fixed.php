<?php
include 'config.php';

// Demo customers data
$demo_data = [
    ['john.doe@example.com', '9876543210', password_hash('pass123', PASSWORD_DEFAULT)],
    ['jane.smith@gmail.com', '9876543211', password_hash('pass456', PASSWORD_DEFAULT)],
    ['test.user@test.com', '9876543212', password_hash('testpass', PASSWORD_DEFAULT)]
];

$inserted = 0;
foreach ($demo_data as $data) {
    try {
        $stmt = $pdo->prepare("INSERT OR IGNORE INTO customers (email, mobile, password, created_at) VALUES (?, ?, ?, datetime('now'))");
        $stmt->execute($data);
        $inserted++;
    } catch (Exception $e) {
        echo "Skipped {$data[0]}: {$e->getMessage()}<br>";
    }
}

// Admin
try {
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);
} catch (Exception $e) {}

$total_customers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();

echo "<h1>Demo Data Added! 🎉</h1>";
echo "<p>Inserted/Updated: $inserted customers</p>";
echo "<p>Total customers now: $total_customers</p>";
echo "<p>Admin login: <strong>admin / admin123</strong></p>";
echo '<p><a href="admin/customers.php" class="btn" style="display:inline-block; padding:10px 20px; background:#4CAF50; color:white; text-decoration:none; border-radius:5px;">View All Customers →</a></p>';
echo '<p><a href="index.php">← Home</a></p>';
?>
<style>
body { font-family: Arial; max-width:600px; margin:50px auto; padding:20px; background:#f5f5f5; }
.btn { background:linear-gradient(45deg, #4CAF50, #45a049); }
h1 { color:#333; }
</style>
