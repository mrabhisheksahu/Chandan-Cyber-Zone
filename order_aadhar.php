<?php
session_start();
include 'config.php';
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

$doc_type = 'Aadhar Card';
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
    <title>Order - Aadhar Card</title>
    <style>
/* Full CSS from previous */
* {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
body { /* full body style */ }
/* all CSS */
    </style>
  </head>
  <body>
    <!-- Full HTML form -->
  </body>
</html>
