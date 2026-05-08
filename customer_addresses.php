<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Saved Addresses - CHANDAN CYBER ZONE</title>
<style>
body { font-family: Cambria, sans-serif; background: linear-gradient(135deg, #07131f, #12385d); color:#fff; padding:20px; }
.container { max-width:800px; margin:0 auto; }
.header { text-align:center; margin-bottom:30px; }
h1 { font-size:28px; margin-bottom:10px; }
.back { color:#ffd86f; font-weight:700; }
.empty { text-align:center; padding:50px; color:#ccc; }
.add-btn { background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; padding:12px 24px; border-radius:12px; font-weight:700; display:inline-block; margin-bottom:20px; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>Saved Addresses</h1>
    <a href="index.php" class="back">← Back to Home</a>
  </div>
  <div class="empty">
    <h3>No saved addresses</h3>
    <p>Add addresses from order forms</p>
    <a href="#" class="add-btn">+ Add New Address</a>
  </div>
</div>
</body>
</html>
