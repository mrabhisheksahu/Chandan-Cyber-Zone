<?php
session_start();
include 'config.php';
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

$doc_type = 'PAN Card';
$price = 139.00;
$success = '';

if ($_POST) {
    $full_name = $_POST['full_name'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $state = $_POST['state'] ?? '';
    $pincode = $_POST['pincode'] ?? '';
    
    $files_json = '[]';
    
    // Handle file uploads
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $files = [];
    if (!empty($_FILES['front_image']['name']) && $_FILES['front_image']['error'] === UPLOAD_ERR_OK) {
        $front_file = $upload_dir . time() . '_front_' . basename($_FILES['front_image']['name']);
        move_uploaded_file($_FILES['front_image']['tmp_name'], $front_file);
        $files[] = $front_file;
    }
    if (!empty($_FILES['back_image']['name']) && $_FILES['back_image']['error'] === UPLOAD_ERR_OK) {
        $back_file = $upload_dir . time() . '_back_' . basename($_FILES['back_image']['name']);
        move_uploaded_file($_FILES['back_image']['tmp_name'], $back_file);
        $files[] = $back_file;
    }
    if (!empty($_FILES['pdf_file']['name']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $pdf_file = $upload_dir . time() . '_pdf_' . basename($_FILES['pdf_file']['name']);
        move_uploaded_file($_FILES['pdf_file']['tmp_name'], $pdf_file);
        $files[] = $pdf_file;
    }
    if (!empty($files)) {
        $files_json = json_encode($files);
    }
    
    $customer_id = isset($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : null;
    $stmt = $pdo->prepare("INSERT INTO orders (doc_type, full_name, mobile, address, city, state, pincode, price, files_json, customer_id, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', datetime('now'))");
    $stmt->execute([$doc_type, $full_name, $mobile, $address, $city, $state, $pincode, $price, $files_json, $customer_id]);
    
    $success = 'Order submitted successfully! Order ID: ' . $pdo->lastInsertId() . ' (Status: Pending payment)';
} 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order - PAN Card</title>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font-family: Cambria, "Times New Roman", serif; background: radial-gradient(circle at top left, rgba(255, 153, 51, 0.15), transparent 26%), radial-gradient(circle at top right, rgba(19, 136, 8, 0.14), transparent 24%), linear-gradient(135deg, #07131f 0%, #0b2238 45%, #12385d 100%); min-height: 100vh; color: #fff; }
      .top-strip { width: 100%; background: linear-gradient(90deg, #ff9933, #ffffff, #138808); color: #091a2f; text-align: center; font-weight: 800; padding: 7px 10px; font-size: 13px; }
      .header { text-align: center; padding: 14px 10px 6px; font-size: 31px; font-weight: 900; letter-spacing: 2px; }
      .sub-title { text-align: center; color: #d8e8ff; font-size: 15px; margin-bottom: 14px; }
      .wrapper { width: min(1020px, 95%); margin: 0 auto 24px; }
      .order-card { background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03)), linear-gradient(145deg, #0a2038, #12355d 68%, #173f70); border: 1px solid rgba(192, 192, 192, 0.45); border-radius: 22px; overflow: hidden; box-shadow: 0 14px 32px rgba(0, 0, 0, 0.35); }
      .card-head { background: linear-gradient(90deg, rgba(180, 190, 200, 0.2), rgba(255, 255, 255, 0.08), rgba(150, 165, 180, 0.2)); padding: 14px 18px; border-bottom: 1px solid rgba(192, 192, 192, 0.35); }
      .card-head h2 { font-size: 24px; font-weight: 900; text-align: center; color: #fff; }
      .card-head p { text-align: center; color: #dce9ff; margin-top: 4px; font-size: 14px; }
      .form-body { padding: 16px; }
      .alert { padding: 11px 14px; border-radius: 12px; margin-bottom: 14px; font-size: 15px; font-weight: 700; background: rgba(40, 167, 69, 0.2); border: 1px solid rgba(40, 167, 69, 0.5); color: #d4edda; }
      /* Full CSS - abbreviated for response */
    </style>
  </head>
  <body>
    <!-- Full form -->
  </body>
</html>
