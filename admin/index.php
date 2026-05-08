<?php
session_start();
include '../config.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
    <meta http-equiv="refresh" content="0;url=login.php">
</head>
<body>
    <p>Redirecting to login...</p>
</body>
</html>
