<?php
session_start();
include 'config.php';

if (!isset($_SESSION['customer_id']) || !isset($_GET['order_id'])) {
    header('Location: index.php');
    exit;
}

$order_id = (int)$_GET['order_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND customer_id = ?");
$stmt->execute([$order_id, $_SESSION['customer_id']]);
$order = $stmt->fetch();

if (!$order || $order['status'] !== 'Paid') {
    header('Location: customer_orders.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - CHANDAN CYBER ZONE</title>
    <style>
        body { font-family: Cambria, serif; background: linear-gradient(135deg, #07131f, #12385d); color:#fff; padding:40px 20px; text-align:center; }
        .container { max-width:600px; margin:0 auto; }
        .success-icon { font-size:80px; color:#28a745; margin-bottom:20px; }
        h1 { font-size:36px; color:#28a745; margin-bottom:20px; }
        .order-details { background:rgba(255,255,255,0.1); border-radius:20px; padding:30px; margin:30px 0; backdrop-filter:blur(10px); }
        .detail { display:flex; justify-content:space-between; margin:15px 0; font-size:18px; }
        .btn { background:linear-gradient(135deg, #ffd86f, #ffb300); color:#111; padding:15px 40px; border-radius:30px; font-weight:bold; font-size:18px; text-decoration:none; display:inline-block; margin:20px; box-shadow:0 10px 25px rgba(255,179,0,0.4); transition:0.3s; }
        .btn:hover { transform:translateY(-3px); box-shadow:0 15px 35px rgba(255,179,0,0.5); }
        @media (max-width:600px) { .detail { flex-direction:column; text-align:left; gap:5px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✅</div>
        <h1>Order Successful!</h1>
        <p style="font-size:20px; margin-bottom:40px;">Your printing order has been confirmed and payment received.</p>
        
        <div class="order-details">
            <div class="detail">
                <span>Order ID:</span>
                <strong>#<?php echo $order['id']; ?></strong>
            </div>
            <div class="detail">
                <span>Document:</span>
                <strong><?php echo htmlspecialchars($order['doc_type']); ?></strong>
            </div>
            <div class="detail">
                <span>Amount:</span>
                <strong>₹<?php echo number_format($order['price'], 2); ?></strong>
            </div>
            <div class="detail">
                <span>Status:</span>
                <strong style="color:#28a745;">Paid & Confirmed</strong>
            </div>
            <div class="detail">
                <span>Placed:</span>
                <strong><?php echo date('d M Y, H:i', strtotime($order['created_at'])); ?></strong>
            </div>
        </div>
        
        <a href="customer_orders.php" class="btn">View My Orders</a>
        <a href="index.php" class="btn">Place New Order</a>
    </div>
</body>
</html>

