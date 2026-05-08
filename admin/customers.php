<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

try {
  $pdo_admin = new PDO('sqlite:../pvc.db');
  $pdo_admin->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$customers = $pdo_admin->query("SELECT id, email AS customer_name, email, mobile, password, created_at FROM customers ORDER BY created_at DESC LIMIT 100")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  $customers = [];
  $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Info - Admin Panel</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #07131f 0%, #0b2238 50%, #12385d 100%); color:#333; min-height:100vh; }
.admin-panel { display:flex; min-height:100vh; }
.sidebar { width:260px; background: linear-gradient(180deg, #0a1a30, #0d2540); border-right:1px solid #1a3a5a; padding:20px 0; position:fixed; height:100vh; overflow:auto; }
.sidebar h2 { color:#fff; text-align:center; margin-bottom:30px; font-size:20px; font-weight:700; padding:0 20px; border-bottom:1px solid #2a4a6a; padding-bottom:15px; }
.nav-link { display:block; padding:15px 25px; color:#c8d8f0; text-decoration:none; font-weight:500; transition:all 0.3s; border-left:3px solid transparent; }
.nav-link:hover { background:rgba(255,216,111,0.1); color:#ffd86f; border-left-color:#ffb300; }
.nav-link.active { background:rgba(255,216,111,0.15); color:#ffd86f; border-left-color:#ffb300; }
.main-content { margin-left:260px; padding:30px; width: 100%; }
.orders-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
.orders-header h1 { color:#fff; font-size:28px; font-weight:700; }
.table-container { background:rgba(255,255,255,0.95); border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
table { width:100%; border-collapse:collapse; }
th { background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; padding:18px 16px; font-weight:900; text-transform:uppercase; font-size:13px; letter-spacing:0.5px; }
td { padding:16px; border-bottom:1px solid #eee; word-break:break-all; }
tr:hover { background:rgba(255,216,111,0.05); }
.stats { display:flex; gap:20px; margin-bottom:20px; flex-wrap:wrap; }
.stat-card { flex:1; min-width:200px; background:rgba(255,255,255,0.95); padding:20px; border-radius:12px; text-align:center; box-shadow:0 8px 20px rgba(0,0,0,0.1); }
.stat-number { font-size:32px; font-weight:900; color:#0b2238; }
.stat-label { color:#666; font-weight:600; text-transform:uppercase; font-size:12px; letter-spacing:1px; }
@media (max-width:768px) { 
  .sidebar { transform:translateX(-100%); } 
  .main-content { margin-left:0; } 
  table { font-size:12px; } 
  th,td { padding:12px 8px; } 
}
</style>
</head>
<body>
<div class="admin-panel">
  <!-- Sidebar -->
  <nav class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php" class="nav-link">Dashboard</a>
    <a href="orders.php" class="nav-link">Orders</a>

    <a href="customers.php" class="nav-link active">Customers</a>
    <a href="change_password.php" class="nav-link">Change Password</a>
    <a href="logout.php" class="nav-link">Logout</a>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <div class="orders-header">
      <h1>Customer Information (All Data from Main DB)</h1>
    </div>

    <?php if (isset($error)): ?>
      <div style="background:#ffe1e1; color:#a40000; padding:15px; border-radius:10px; margin-bottom:20px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="stats">
      <div class="stat-card">
        <div class="stat-number"><?php echo count($customers); ?></div>
        <div class="stat-label">Total Customers</div>
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Password</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($customers as $customer): ?>
          <tr>
            <td><strong>#<?php echo $customer['id']; ?></strong></td>
            <td><?php echo htmlspecialchars($customer['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($customer['email']); ?></td>
            <td><?php echo htmlspecialchars($customer['mobile']); ?></td>
            <td><?php echo htmlspecialchars(substr($customer['password'], 0, 20)) . '...'; ?></td>
            <td><?php echo date('d M Y H:i', strtotime($customer['created_at'])); ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($customers)): ?>
          <tr>
            <td colspan="6" style="text-align:center; padding:40px; color:#999; font-style:italic;">
              No customers yet. Register from <a href="../customer_register.php" style="color:#ffb300;">Customer Register</a>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>
