<?php
header('Location: login.php#customer');
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Login</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:Cambria, "Times New Roman", serif; min-height:100vh; display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, #07131f, #0b2238, #12385d); }
.card { width:100%; max-width:420px; background:#fff; border-radius:22px; padding:28px; box-shadow:0 20px 50px rgba(0,0,0,0.3); }
h1 { text-align:center; color:#0b2238; margin-bottom:18px; font-size:30px; }
.tab-nav { display:flex; margin-bottom:24px; }
.tab-btn { flex:1; padding:14px; border:none; background:#f8f9fa; color:#666; font-weight:700; cursor:pointer; border-radius:12px 12px 0 0; transition:0.3s; font-size:16px; }
.tab-btn.active { background:#fff; color:#0b2238; box-shadow:0 -2px 10px rgba(0,0,0,0.1); }
.tab-content { display:none; }
.tab-content.active { display:block; }
.error { background:#ffe1e1; color:#a40000; padding:10px 12px; border-radius:10px; margin-bottom:14px; font-weight:700; }
label { display:block; margin-bottom:6px; margin-top:10px; font-weight:700; color:#0b2238; }
.input { width:100%; padding:12px 14px; border:1px solid #cfd8e3; border-radius:12px; font-size:16px; outline:none; transition:border-color 0.3s; }
.input:focus { border-color:#ffb300; }
.btn { width:100%; margin-top:18px; padding:13px; border:none; border-radius:12px; font-weight:800; font-size:16px; cursor:pointer; color:#111; background: linear-gradient(135deg, #ffd86f, #ffb300); box-shadow:0 4px 15px rgba(255,179,0,0.3); transition:0.3s; }
.btn:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(255,179,0,0.4); }
.otp-form { display:<?php echo $step=='verify_otp' ? 'block' : 'none'; ?>; }
.resend { text-align:center; margin-top:15px; color:#666; font-size:14px; }
.back { display:block; text-align:center; margin-top:14px; color:#0b2238; text-decoration:none; font-weight:700; }
@media (max-width:480px) { .card { margin:20px; padding:20px; } }
</style>
</head>
<body>
<div class="card">
  <h1>Customer Login</h1>
  <?php if ($error): echo '<div class="error">' . $error . '</div>'; endif; ?>
  
  <form method="post">
    <input type="hidden" name="action" value="password_login">
    <label>Email or Mobile *</label>
    <input class="input" type="text" name="username" value="<?php echo htmlspecialchars($identifier); ?>" placeholder="Enter email or mobile" required>
    <!-- Radio Options -->
      <div style="margin-top: 15px;">
        <label class="radio-option">
          <input type="radio" name="login_method" value="password" id="password-radio" checked>
          <span>Login with Password</span>
        </label>
        <label class="radio-option">
          <input type="radio" name="login_method" value="otp" id="otp-radio">
          <span>Login with OTP</span>
        </label>
      </div>
    <label>Password *</label>
    <input class="input" type="password" name="password" placeholder="Enter password" required>
    <button type="submit" class="btn">Login</button>
  </form>
  
  <div style="margin-top: 20px; text-align: center;">
    <a href="customer_register.php" style="color: #0b2238; font-weight: bold; font-size: 16px;">Create Account</a>
  </div>
  
  <a href="index.php" class="back" style="margin-top: 20px;">← Back to Home</a>

  <style>
    .radio-option {
      display: block;
      margin-bottom: 12px;
      cursor: pointer;
      padding: 10px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      transition: border-color 0.3s;
    }
    .radio-option input[type="radio"] {
      margin-right: 8px;
    }
    .radio-option:hover {
      border-color: #ffb300;
    }
    .btn-small {
      padding: 8px 16px !important;
      font-size: 14px !important;
      width: auto !important;
    }
  </style>
  
  <a href="login.php" class="back">Other Options</a>
  <a href="customer_register.php" class="back" style="margin-top:5px;">Create Account</a>
</div>

<script>
function showTab(tabName) {
  document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  document.getElementById(tabName).classList.add('active');
  event.target.classList.add('active');
}

if ('<?php echo $step; ?>' == 'verify_otp') {
  document.getElementById('otp').classList.add('active');
  document.querySelector('.tab-btn[onclick="showTab(\'otp\')"]').classList.add('active');
  document.querySelector('.tab-btn[onclick="showTab(\'password\')"]').classList.remove('active');
  document.getElementById('verify-otp-form').style.display = 'block';
  document.getElementById('send-otp-form').style.display = 'none';
}
</script>
</body>
</html>
