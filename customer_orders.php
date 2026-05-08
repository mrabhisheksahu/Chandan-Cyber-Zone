<?php
session_start();
include 'config.php';

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC");
    $stmt->execute([$_SESSION['customer_id']]);
    $orders = $stmt->fetchAll();
} catch (PDOException $e) {
    $orders = [];
    error_log("Orders query error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>My Orders - CHANDAN CYBER ZONE</title>
<style>
body { font-family: Cambria, sans-serif; background: linear-gradient(135deg, #07131f, #12385d); color:#fff; padding:20px; }
.container { max-width:1200px; margin:0 auto; }
.header { text-align:center; margin-bottom:30px; }
h1 { font-size:28px; margin-bottom:10px; }
.back { color:#ffd86f; font-weight:700; }
.table { width:100%; background:rgba(255,255,255,0.95); border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.3); }
th, td { padding:14px; text-align:left; border-bottom:1px solid #eee; }
th { background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; font-weight:900; }
.status { padding:4px 10px; border-radius:12px; font-weight:700; font-size:13px; }
.status-Pending { background:#fff3cd; color:#856404; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>My Orders</h1>
    <a href="index.php" class="back">← Back to Home</a>
  </div>
  <?php if (empty($orders)): ?>
    <div style="text-align:center; padding:50px; color:#ccc;">No orders yet</div>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Document</th>
          <th>Date</th>
          <th>Price</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
          <td>#<?php echo $order['id']; ?></td>
          <td><?php echo htmlspecialchars($order['doc_type']); ?></td>
          <td><?php echo date('Y-m-d', strtotime($order['created_at'])); ?></td>
          <td>₹<?php echo $order['price']; ?></td>
          <td><span class="status status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
