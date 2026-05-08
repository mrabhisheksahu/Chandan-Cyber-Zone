<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle status update
if ($_POST && isset($_POST['order_id']) && isset($_POST['status'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
    header('Location: dashboard.php');
    exit;
}

// Stats queries
$total_stmt = $pdo->query("SELECT COUNT(*) FROM orders");
$total_orders = $total_stmt->fetchColumn();
$pending_stmt = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'Pending'");
$pending_orders = $pending_stmt->fetchColumn();
$approved_stmt = $pdo->query("SELECT COUNT(*) FROM orders WHERE status IN ('Processing', 'Ready', 'Pickup')");
$approved_orders = $approved_stmt->fetchColumn();
$rejected_stmt = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'Rejected'");
$rejected_orders = $rejected_stmt->fetchColumn();

$success_payments = 2;

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 8");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #07131f 0%, #0b2238 50%, #12385d 100%); min-height:100vh; color:#333; }
.admin-panel { display:flex; min-height:100vh; }
.sidebar { width:260px; background: linear-gradient(180deg, #0a1a30, #0d2540); border-right:1px solid #1a3a5a; padding:20px 0; }
.sidebar h2 { color:#fff; text-align:center; margin-bottom:30px; font-size:20px; font-weight:700; padding:0 20px; border-bottom:1px solid #2a4a6a; padding-bottom:15px; }
.nav-link { display:block; padding:15px 25px; color:#c8d8f0; text-decoration:none; font-weight:500; transition:all 0.3s; border-left:3px solid transparent; }
.nav-link:hover, .nav-link.active { background:rgba(255,216,111,0.1); color:#ffd86f; border-left-color:#ffb300; }
.main-content { flex:1; padding:30px; }
.stats-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:20px; margin-bottom:30px; }
.stat-card { background:rgba(255,255,255,0.95); border-radius:16px; padding:25px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
.stat-number { font-size:36px; font-weight:900; color:#0b2238; margin-bottom:8px; }
.stat-label { color:#666; font-weight:600; text-transform:uppercase; font-size:12px; letter-spacing:1px; }
.table-container { background:rgba(255,255,255,0.95); border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
table { width:100%; border-collapse:collapse; }
th { background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; padding:18px 16px; font-weight:900; text-transform:uppercase; font-size:13px; letter-spacing:0.5px; }
td { padding:16px; border-bottom:1px solid #eee; }
tr:hover { background:rgba(255,216,111,0.05); }
.badge { padding:6px 12px; border-radius:20px; font-weight:700; font-size:12px; }
.badge-pending-payment { background:#cce5ff; color:#004085; }
.badge-pending-status { background:#fff3cd; color:#856404; }
.status-update { white-space:nowrap; }
.status-update select { padding:8px 12px; border:1px solid #ddd; border-radius:8px; margin-right:8px; font-size:14px; }
.status-update button { padding:8px 14px; background:#28a745; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600; }
.status-update button:hover { background:#218838; }
@media (max-width:1200px) { .stats-grid { grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); } }
@media (max-width:768px) { .sidebar { width:100%; position:fixed; z-index:1000; transform:translateX(-100%); } /* Mobile sidebar toggle needed */ table { font-size:12px; } th,td { padding:12px 8px; } }
</style>
</head>
<body>
<div class="admin-panel">
  <!-- Sidebar -->
  <nav class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php" class="nav-link active">Dashboard</a>
    <a href="orders.php" class="nav-link">Orders</a>
    <a href="customers.php" class="nav-link">Customer info</a>
    <a href="change_password.php" class="nav-link">Change Password</a>
    <a href="logout.php" class="nav-link">Logout</a>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number"><?php echo $total_orders; ?></div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo $pending_orders; ?></div>
        <div class="stat-label">Pending Orders</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo $approved_orders; ?></div>
        <div class="stat-label">Approved Orders</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo $rejected_orders; ?></div>
        <div class="stat-label">Rejected Orders</div>
      </div>

      <div class="stat-card">
        <div class="stat-number"><?php echo $success_payments; ?></div>
        <div class="stat-label">Success Payments</div>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Document</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Charge</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['doc_type']); ?></td>
            <td><?php echo htmlspecialchars(substr($order['full_name'], 0, 20)) . (strlen($order['full_name']) > 20 ? '...' : ''); ?></td>
            <td><?php echo htmlspecialchars($order['mobile']); ?></td>
            <td>₹<?php echo $order['price']; ?></td>
            <td><span class="badge badge-pending-payment">PENDING</span></td>
            <td>
              <span class="badge badge-pending-status status-<?php echo strtolower($order['status']); ?>"><?php echo htmlspecialchars($order['status']); ?></span>
            </td>
            <td><?php echo date('Y-m-d H:i', strtotime($order['created_at'])); ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($orders)): ?>
          <tr><td colspan="8" style="text-align:center; padding:40px; color:#999;">No orders yet</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>
