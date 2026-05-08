<?php
session_start();
include '../config.php';

$error = $success = '';

if ($_POST) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    
    if ($new_pass !== $confirm_pass) {
        $error = 'New passwords do not match.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT password FROM admins WHERE id = ?");
            $stmt->execute([$_SESSION['admin_id']]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($current_pass, $admin['password'])) {
                $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
                $stmt->execute([$new_hash, $_SESSION['admin_id']]);
                $success = 'Password changed successfully!';
            } else {
                $error = 'Current password incorrect.';
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password - Admin</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #07131f 0%, #0b2238 50%, #12385d 100%); min-height:100vh; }
.admin-panel { display:flex; min-height:100vh; }
.sidebar { width:260px; background: linear-gradient(180deg, #0a1a30, #0d2540); border-right:1px solid #1a3a5a; padding:20px 0; position:fixed; height:100vh; overflow:auto; }
.sidebar h2 { color:#fff; text-align:center; margin-bottom:30px; font-size:20px; font-weight:700; padding:0 20px; border-bottom:1px solid #2a4a6a; padding-bottom:15px; }
.nav-link { display:block; padding:15px 25px; color:#c8d8f0; text-decoration:none; font-weight:500; transition:all 0.3s; border-left:3px solid transparent; }
.nav-link:hover, .nav-link.active { background:rgba(255,216,111,0.1); color:#ffd86f; border-left-color:#ffb300; }
.main-content { margin-left:260px; padding:30px; }
.form-card { background:rgba(255,255,255,0.95); border-radius:16px; padding:40px; max-width:500px; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
.form-card h1 { color:#0b2238; margin-bottom:30px; text-align:center; }
.success { background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:20px; }
.error { background:#ffe1e1; color:#a40000; padding:12px; border-radius:8px; margin-bottom:20px; }
label { display:block; margin-bottom:8px; font-weight:600; color:#0b2238; }
.input { width:100%; padding:12px 16px; border:1px solid #ddd; border-radius:8px; font-size:16px; margin-bottom:20px; }
.btn { width:100%; padding:14px; background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; border:none; border-radius:8px; font-weight:700; font-size:16px; cursor:pointer; }
.btn:hover { transform:translateY(-1px); }
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
    <a href="customers.php" class="nav-link">Customer info</a>
    <a href="change_password.php" class="nav-link active">Change Password</a>
    <a href="logout.php" class="nav-link">Logout</a>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <div class="form-card">
      <h1>Change Password</h1>
      <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
      <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
      <form method="post">
        <label>Current Password</label>
        <input class="input" type="password" name="current_password" required>
        <label>New Password</label>
        <input class="input" type="password" name="new_password" required minlength="6">
        <label>Confirm New Password</label>
        <input class="input" type="password" name="confirm_password" required minlength="6">
        <button type="submit" class="btn">Update Password</button>
      </form>
      <p style="text-align:center; margin-top:20px; color:#666;">Current default: <strong>admin123</strong></p>
    </div>
  </main>
</div>
</body>
</html>
