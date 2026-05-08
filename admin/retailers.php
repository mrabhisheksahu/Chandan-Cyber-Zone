<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Retailers - Admin Panel</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #07131f 0%, #0b2238 50%, #12385d 100%); color:#333; min-height:100vh; }
.admin-panel { display:flex; min-height:100vh; }
.sidebar { width:260px; background: linear-gradient(180deg, #0a1a30, #0d2540); border-right:1px solid #1a3a5a; padding:20px 0; position:fixed; height:100vh; overflow:auto; }
.sidebar h2 { color:#fff; text-align:center; margin-bottom:30px; font-size:20px; font-weight:700; padding:0 20px; border-bottom:1px solid #2a4a6a; padding-bottom:15px; }
.nav-link { display:block; padding:15px 25px; color:#c8d8f0; text-decoration:none; font-weight:500; transition:all 0.3s; border-left:3px solid transparent; }
.nav-link:hover { background:rgba(255,216,111,0.1); color:#ffd86f; border-left-color:#ffb300; }
.nav-link.active { background:rgba(255,216,111,0.15); color:#ffd86f; border-left-color:#ffb300; }
.main-content { margin-left:260px; padding:30px; }
.page-header { margin-bottom:30px; }
.page-header h1 { color:#fff; font-size:28px; font-weight:700; margin-bottom:10px; }
.empty-state { background:rgba(255,255,255,0.95); border-radius:16px; padding:60px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
.empty-state h3 { color:#0b2238; font-size:24px; margin-bottom:15px; }
.empty-state p { color:#666; font-size:16px; margin-bottom:25px; }
.btn-add { padding:12px 30px; background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; text-decoration:none; border-radius:12px; font-weight:700; font-size:16px; display:inline-block; box-shadow:0 5px 15px rgba(255,181,0,0.4); transition:transform 0.2s; }
.btn-add:hover { transform:translateY(-2px); }
@media (max-width:768px) { .sidebar { transform:translateX(-100%); } .main-content { margin-left:0; } }
</style>
</head>
<body>
<div class="admin-panel">
  <!-- Sidebar -->
  <nav class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php" class="nav-link">Dashboard</a>
    <a href="orders.php" class="nav-link">Orders</a>
    <a href="retailers.php" class="nav-link active">Retailers</a>
    <a href="customers.php" class="nav-link">Customer info</a>
    <a href="logout.php" class="nav-link">Logout</a>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <div class="page-header">
      <h1>Retailers Management</h1>
    </div>
    
    <div class="empty-state">
      <h3>No Retailers Yet</h3>
      <p>Retailers will appear here once added. Manage your retailer network from this panel.</p>
      <a href="#" class="btn-add">+ Add New Retailer</a>
    </div>
  </main>
</div>
</body>
</html>
