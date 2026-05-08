<?php
session_start();
include '../config.php';

$error = '';
if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
/* Full CSS from admin/login.html */
* { margin:0;padding:0;box-sizing:border-box; }
body { font-family:Cambria, \"Times New Roman\", serif; min-height:100vh; display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, #07131f, #0b2238, #12385d); }
.card { width:100%; max-width:420px; background:#fff; border-radius:22px; padding:28px; box-shadow:0 20px 50px rgba(0,0,0,.30); }
h1 { text-align:center; color:#0b2238; margin-bottom:18px; font-size:30px; }
.error { background:#ffe1e1; color:#a40000; padding:10px 12px; border-radius:10px; margin-bottom:14px; font-weight:700; }
label { display:block; margin-bottom:6px; margin-top:10px; font-weight:700; color:#0b2238; }
.input { width:100%; padding:12px 14px; border:1px solid #cfd8e3; border-radius:12px; font-size:16px; outline:none; }
.btn { width:100%; margin-top:18px; padding:13px; border:none; border-radius:12px; font-weight:800; font-size:16px; cursor:pointer; color:#111; background: linear-gradient(135deg, #ffd86f, #ffb300); }
.back { display:block; text-align:center; margin-top:14px; color:#0b2238; text-decoration:none; font-weight:700; }
</style>
</head>
<body>
<div class="card">
<h1>Admin Login</h1>
<?php if ($error) echo '<div class="error">' . $error . '</div>'; ?>
<form method="post">
<label>Username</label>
<input class="input" type="text" name="username" placeholder="Enter username" required>
<label>Password</label>
<input class="input" type="password" name="password" placeholder="Enter password" required>
<button type="submit" class="btn">Login</button>
</form>
<a href="../index.php" class="back">Back to Home</a>
</div>
</body>
</html>

