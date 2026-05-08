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
    header('Location: orders.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders - Admin Panel</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #07131f 0%, #0b2238 50%, #12385d 100%); color:#333; min-height:100vh; }
.admin-panel { display:flex; min-height:100vh; }
.sidebar { width:260px; background: linear-gradient(180deg, #0a1a30, #0d2540); border-right:1px solid #1a3a5a; padding:20px 0; position:fixed; height:100vh; overflow:auto; }
.sidebar h2 { color:#fff; text-align:center; margin-bottom:30px; font-size:20px; font-weight:700; padding:0 20px; border-bottom:1px solid #2a4a6a; padding-bottom:15px; }
.nav-link { display:block; padding:15px 25px; color:#c8d8f0; text-decoration:none; font-weight:500; transition:all 0.3s; border-left:3px solid transparent; }
.nav-link:hover { background:rgba(255,216,111,0.1); color:#ffd86f; border-left-color:#ffb300; }
.nav-link.active { background:rgba(255,216,111,0.15); color:#ffd86f; border-left-color:#ffb300; }
.main-content { margin-left:260px; padding:30px;width: 100% }
.orders-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
.orders-header h1 { color:#fff; font-size:28px; font-weight:700; }
.search-box { padding:12px 20px; border:1px solid #3a5a7a; border-radius:12px; background:rgba(255,255,255,0.1); color:#fff; font-size:16px; width:300px; }
.table-container { background:rgba(255,255,255,0.95); border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
table { width:100%; border-collapse:collapse; }
th { background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; padding:18px 16px; font-weight:900; text-transform:uppercase; font-size:13px; letter-spacing:0.5px; }
td { padding:16px; border-bottom:1px solid #eee; }
tr:hover { background:rgba(255,216,111,0.05); }
.status-update { white-space:nowrap; }
.status-update select { padding:8px 12px; border:1px solid #ddd; border-radius:8px; margin-right:8px; font-size:14px; }
.status-update button { padding:8px 14px; background:#28a745; color:white; border:none; border-radius:8px; cursor:pointer; font-weight:600; }
.status-update button:hover { background:#218838; }
.badge { padding:6px 12px; border-radius:20px; font-weight:700; font-size:12px; }
.badge-pending-payment { background:#cce5ff; color:#004085; }
.badge-Pending { background:#fff3cd; color:#856404; }
.badge-Processing { background:#cce5ff; color:#004085; }
.badge-Ready { background:#d4edda; color:#155724; }
.badge-Pickup { background:#f8d7da; color:#721c24; }
@media (max-width:768px) { .sidebar { transform:translateX(-100%); } .main-content { margin-left:0; } table { font-size:12px; } th,td { padding:12px 8px; } }
</style>
</head>
<body>
<div class="admin-panel">
  <!-- Sidebar -->
  <nav class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php" class="nav-link">Dashboard</a>
    <a href="orders.php" class="nav-link active">Orders</a>

    <a href="customers.php" class="nav-link">Customer info</a>
    <a href="change_password.php" class="nav-link">Change Password</a>
    <a href="logout.php" class="nav-link">Logout</a>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <div class="orders-header">
      <h1>Orders Management</h1>
      <input type="text" class="search-box" placeholder="Search orders...">
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Document</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Price</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Action</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['doc_type']); ?></td>
            <td><?php echo htmlspecialchars(substr($order['full_name'], 0, 15)) . '...'; ?></td>
            <td><?php echo htmlspecialchars($order['mobile']); ?></td>
            <td><?php echo htmlspecialchars(substr($order['address'], 0, 25)) . '...'; ?></td>
            <td>₹<?php echo $order['price']; ?></td>
            <td><span class="badge badge-pending-payment">PENDING</span></td>
            <td><span class="badge badge-<?php echo $order['status']; ?>"><?php echo htmlspecialchars($order['status']); ?></span></td>
            <td>
              <form method="post" class="status-update">
                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                <select name="status">
                  <option value="Pending" <?php echo $order['status']=='Pending' ? 'selected' : ''; ?>>Pending</option>
                  <option value="Processing" <?php echo $order['status']=='Processing' ? 'selected' : ''; ?>>Processing</option>
                  <option value="Ready" <?php echo $order['status']=='Ready' ? 'selected' : ''; ?>>Ready</option>
                  <option value="Pickup" <?php echo $order['status']=='Pickup' ? 'selected' : ''; ?>>Pickup</option>
                  <option value="Rejected" <?php echo $order['status']=='Rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
                <button type="submit">Update</button>
              </form>
            </td>
            <td><?php echo date('Y-m-d H:i', strtotime($order['created_at'])); ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($orders)): ?>
          <tr><td colspan="10" style="text-align:center; padding:40px; color:#999;">No orders found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>
