<?php
include 'config.php';
$success = $error = $step = $mobile = '';

if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'register_password') {
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO customers (email, mobile, password) VALUES (?, ?, ?)");
            $stmt->execute([$email, $mobile, $password]);
$success = 'Account created successfully! 🎉 ID: ' . $pdo->lastInsertId() . '. <a href="login.php">Login Now</a>';
        } catch (PDOException $e) {
            $error = 'Email or mobile already exists.';
        }
    } elseif ($action == 'send_register_otp') {
        $mobile = trim($_POST['mobile']);
        $email = trim($_POST['email']);
        
        // Check if exists
        $stmt = $pdo->prepare("SELECT id FROM customers WHERE email = ? OR mobile = ?");
        $stmt->execute([$email, $mobile]);
        if ($stmt->fetch()) {
            $error = 'Email or mobile already registered.';
        } else {
            $otp = generate_otp();
            $_SESSION['register_temp'] = ['email' => $email, 'mobile' => $mobile, 'otp' => $otp];
            send_sms_otp($mobile, $otp);
            $step = 'verify_register_otp';
        }
    } elseif ($action == 'verify_register_otp') {
        $otp = trim($_POST['otp']);
        if (isset($_SESSION['register_temp']) && $_SESSION['register_temp']['otp'] == $otp) {
            $data = $_SESSION['register_temp'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO customers (email, mobile, password) VALUES (?, ?, ?)");
            $stmt->execute([$data['email'], $data['mobile'], $password]);
unset($_SESSION['register_temp']);
            $success = 'Account created successfully with OTP! 🎉 ID: ' . $pdo->lastInsertId() . '. <a href="login.php" style="color: #0b2238; font-weight: bold;">Login Now</a>';
        } else {
            $error = 'Invalid or expired OTP.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account - CHANDAN CYBER ZONE</title>
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
.success { background:#d4edda; color:#155724; padding:10px 12px; border-radius:10px; margin-bottom:14px; font-weight:700; }
.error { background:#ffe1e1; color:#a40000; padding:10px 12px; border-radius:10px; margin-bottom:14px; font-weight:700; }
label { display:block; margin-bottom:6px; margin-top:10px; font-weight:700; color:#0b2238; }
.input { width:100%; padding:12px 14px; border:1px solid #cfd8e3; border-radius:12px; font-size:16px; outline:none; transition:border-color 0.3s; }
.input:focus { border-color:#ffb300; }
.btn { width:100%; margin-top:18px; padding:13px; border:none; border-radius:12px; font-weight:800; font-size:16px; cursor:pointer; color:#111; background: linear-gradient(135deg, #ffd86f, #ffb300); box-shadow:0 4px 15px rgba(255,179,0,0.3); transition:0.3s; }
.btn:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(255,179,0,0.4); }
.otp-form { display:<?php echo $step=='verify_register_otp' ? 'block' : 'none'; ?>; }
.resend { text-align:center; margin-top:15px; color:#666; font-size:14px; }
.links { text-align:center; margin-top:20px; }
.links a { color:#0b2238; text-decoration:none; font-weight:700; }
.links a:hover { color:#ffb300; }
.back { display:block; text-align:center; margin-top:14px; color:#0b2238; text-decoration:none; font-weight:700; }
@media (max-width:480px) { .card { margin:20px; padding:20px; } }
</style>
</head>
<body>
<div class="card">
  <h1>Create Account</h1>
  <?php if ($success): echo '<div class="success">' . $success . '</div>'; endif; ?>
  <?php if ($error): echo '<div class="error">' . $error . '</div>'; endif; ?>
  
  <!-- Single Register Form with OTP Verification -->
  <form method="post" id="register-form">
    <input type="hidden" name="action" value="send_register_otp">
    
    <label>Email *</label>
    <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
    
    <label>Mobile Number *</label>
    <input class="input" type="tel" name="mobile" maxlength="10" value="<?php echo htmlspecialchars($mobile ?? $_POST['mobile'] ?? ''); ?>" required>
    
    <label>Password *</label>
    <input class="input" type="password" name="password" required>
    
    <?php if ($step == 'verify_register_otp'): ?>
      <input type="hidden" name="action" value="verify_register_otp">
<label>Enter OTP (sent to <?php echo htmlspecialchars($mobile); ?>)</label>
<div style="background:#d4edda;color:#155724;padding:10px;border-radius:10px;font-weight:bold;margin-bottom:10px;text-align:center;">Demo OTP: <?php echo $_SESSION['register_temp']['otp'] ?? 'N/A'; ?> (for testing, remove prod)</div>
<input class="input" type="text" name="otp" maxlength="6" placeholder="Enter 6-digit OTP" required>
      <div style="text-align: center; color: #666; margin: 10px 0;">OTP expires in 5 minutes. Check SMS or error_log.</div>
      <button type="submit" class="btn">Verify OTP & Create Account</button>
    <?php else: ?>
      <button type="submit" class="btn">Send OTP & Create Account</button>
      <div style="text-align: center; color: #666; margin-top: 15px; font-size: 14px;">
        We'll send OTP to your mobile for verification
      </div>
    <?php endif; ?>
  </form>

  <div class="links" style="margin-top: 20px;">
    <a href="customer_login.php" style="color: #0b2238; font-weight: bold;">Already have account? Login</a>
  </div>
  <a href="index.php" class="back">Back to Home</a>
  
 
</div>

<script>
function showTab(tabName) {
  document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  document.getElementById(tabName).classList.add('active');
  event.target.classList.add('active');
}

if ('<?php echo $step; ?>' == 'verify_register_otp') {
  document.getElementById('otp').classList.add('active');
  document.querySelector('.tab-btn[onclick="showTab(\'otp\')"]').classList.add('active');
  document.getElementById('verify-register-otp').style.display = 'block';
  document.getElementById('send-register-otp').style.display = 'none';
}
</script>
</body>
</html>
