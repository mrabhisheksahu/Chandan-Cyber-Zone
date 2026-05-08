<?php
session_start();
include 'config.php';

$customer_error = '';
$username_value = '';

if ($_POST && isset($_POST['action'])) {
  $action = $_POST['action'];
  $username_value = htmlspecialchars(trim($_POST['username'] ?? ''));

  if ($action === 'customer_password_login') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ? OR mobile = ?");
    $stmt->execute([$username, $username]);
    $customer = $stmt->fetch();
    
    if ($customer && password_verify($password, $customer['password'])) {
      $_SESSION['customer_id'] = $customer['id'];
      header('Location: index.php?login_success=1');
      exit;
    } else {
      $customer_error = 'Invalid email/mobile or password.';
    }
  } elseif ($action === 'customer_send_otp' || $action === 'customer_verify_otp') {
    $identifier = trim($_POST['username'] ?? $_SESSION['otp_identifier'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ? OR mobile = ?");
    $stmt->execute([$identifier, $identifier]);
    $customer = $stmt->fetch();
    
    if (!$customer) {
      $customer_error = 'Customer not found.';
      goto end_otp;
    }
    
    $otp = trim($_POST['otp'] ?? '');
    if ($otp) {
      // Verify
      $verified = verify_customer_otp($identifier, $otp);
      if ($verified) {
        $_SESSION['customer_id'] = $verified['id'];
        unset($_SESSION['otp_identifier']);
        header('Location: index.php?login_success=1');
        exit;
      } else {
        $customer_error = 'Invalid or expired OTP.';
      }
    } else {
      // Send
      $otp_sent = generate_otp();
      set_customer_otp($customer['id'], $otp_sent);
      send_sms_otp($identifier, $otp_sent);
      $_SESSION['otp_identifier'] = $identifier;
      $customer_error = "OTP sent to $identifier (check SMS or error_log)";
    }
    end_otp:
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - CHANDAN CYBER ZONE</title>
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
.error, .success { padding:10px 12px; border-radius:10px; margin-bottom:14px; font-weight:700; }
.error { background:#ffe1e1; color:#a40000; }
.success { background:#d4edda; color:#155724; }
label { display:block; margin-bottom:6px; margin-top:10px; font-weight:700; color:#0b2238; }
.input { width:100%; padding:12px 14px; border:1px solid #cfd8e3; border-radius:12px; font-size:16px; outline:none; transition:border-color 0.3s; }
.input:focus { border-color:#ffb300; }
.btn { width:100%; margin-top:18px; padding:13px; border:none; border-radius:12px; font-weight:800; font-size:16px; cursor:pointer; color:#111; background: linear-gradient(135deg, #ffd86f, #ffb300); box-shadow:0 4px 15px rgba(255,179,0,0.3); transition:0.3s; }
.btn:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(255,179,0,0.4); }
.btn-green { background: linear-gradient(135deg, #138808, #28a745) !important; }
.links { text-align:center; margin-top:20px; }
.links a { color:#0b2238; text-decoration:none; font-weight:700; }
.links a:hover { color:#ffb300; }
.back { display:block; text-align:center; margin-top:14px; color:#0b2238; text-decoration:none; font-weight:700; }
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
.otp-section { display: none; margin-top: 15px; }
@media (max-width:480px) { 
  .card { margin:20px; padding:20px; } 
  .tab-btn { padding:12px; font-size:15px; } 
  .topbar { padding:8px 12px; }
  .brand-logo { width:45px; height:45px; }
}
</style>
</head>
<body>
<div class="card">
  <h1>Login</h1>
  
  <!-- Tab Navigation -->
  <div class="tab-nav">
    <button class="tab-btn active" onclick="showTab('customer')">Customer Login</button>
    <button class="tab-btn" onclick="showTab('admin')">Admin Login</button>
  </div>

  <!-- Customer Login Tab -->
  <div id="customer" class="tab-content active">
    <?php if ($customer_error): ?>
      <div class="error"><?php echo $customer_error; ?></div>
    <?php endif; ?>

    <form method="post" action="" id="customerForm">
<input type="hidden" name="action" id="formAction" value="customer_password_login">
<input type="hidden" name="username" value="<?php echo $username_value; ?>">
      <label>Email or Mobile *</label>
      <input class="input" type="text" name="username" value="<?php echo $username_value; ?>" placeholder="Enter email or mobile" required>
      
      <!-- Radio Options -->
      <div style="margin-top: 15px;">
        <label class="radio-option">
          <input type="radio" name="login_method" value="password" id="password-radio" checked onclick="toggleLoginMethod('password')">
          <span>Login with Password</span>
        </label>
        <label class="radio-option">
          <input type="radio" name="login_method" value="otp" id="otp-radio" onclick="toggleLoginMethod('otp')">
          <span>Login with OTP</span>
        </label>
      </div>

      <!-- Password Section (default) -->
      <div id="passwordSection">
        <label>Password *</label>
        <input class="input" type="password" name="password" placeholder="Enter password" required>
        <button type="submit" class="btn btn-green">Customer Login</button>
      </div>

      <!-- OTP Section (hidden initially) -->
<div id="otpSection" class="otp-section">
        <label style="color:#0b2238; font-weight:700;">Enter 6-digit OTP</label>
        <input class="input" type="text" name="otp" maxlength="6" placeholder="Enter OTP" >
        <button type="submit" class="btn" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">Verify OTP</button>
        <div style="text-align: center; color: #666; margin-top: 10px; font-size: 12px;">Demo: OTP shown after send above</div>
      </div>
    </form>

    <div class="links">
      <a href="customer_register.php">Register New Account</a>
    </div>
  </div>

  <!-- Admin Login Tab -->
  <div id="admin" class="tab-content">
    <form method="post" action="admin/login.php">
      <label>Username</label>
      <input class="input" type="text" name="username" placeholder="Enter username" required>
      <label>Password</label>
      <input class="input" type="password" name="password" placeholder="Enter password" required>
      <button type="submit" class="btn">Admin Login</button>
    </form>
  </div>

  <div style="margin-top: 20px; text-align: center;">
    <a href="index.php" class="back">← Back to Home</a>
  </div>
</div>

<script>
function showTab(tabName) {
  const tabs = document.querySelectorAll('.tab-content');
  tabs.forEach(tab => tab.classList.remove('active'));
  
  const btns = document.querySelectorAll('.tab-btn');
  btns.forEach(btn => btn.classList.remove('active'));
  
  document.getElementById(tabName).classList.add('active');
  event.target.classList.add('active');
}

function toggleLoginMethod(method) {
  const formAction = document.getElementById('formAction');
  const passwordSection = document.getElementById('passwordSection');
  const otpSection = document.getElementById('otpSection');
  
  if (method === 'otp') {
    formAction.value = 'customer_send_otp';
    passwordSection.style.display = 'none';
    otpSection.style.display = 'block';
    document.querySelector('input[name="password"]').removeAttribute('required');
  } else {
    formAction.value = 'customer_password_login';
    passwordSection.style.display = 'block';
    otpSection.style.display = 'none';
    document.querySelector('input[name="password"]').setAttribute('required', 'required');
  }
}

if (window.location.hash === '#customer') {
  showTab('customer');
}
</script>
</body>
</html>

