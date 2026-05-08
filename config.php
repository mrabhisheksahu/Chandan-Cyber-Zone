<?php
$database_file = 'pvc.db';

try {
    $pdo = new PDO('sqlite:' . $database_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT
    )");

    // Customers table with OTP fields
    $pdo->exec("CREATE TABLE IF NOT EXISTS customers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT UNIQUE,
        mobile TEXT UNIQUE,
        password TEXT,
        otp TEXT,
        otp_expires DATETIME,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Add OTP columns safely (skip if exist)
    $stmt = $pdo->query("PRAGMA table_info(customers)");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
    try {
        if (!in_array('otp', $columns)) {
            $pdo->exec("ALTER TABLE customers ADD COLUMN otp TEXT");
        }
    } catch (Exception $e) { /* Column may exist */ }
    try {
        if (!in_array('otp_expires', $columns)) {
            $pdo->exec("ALTER TABLE customers ADD COLUMN otp_expires DATETIME");
        }
    } catch (Exception $e) { /* Column may exist */ }
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        doc_type TEXT,
        full_name TEXT,
        mobile TEXT,
        address TEXT,
        city TEXT,
        state TEXT,
        pincode TEXT,
        price REAL,
        customer_id INTEGER,
        status TEXT DEFAULT 'Pending',
        files_json TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert default admin if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO admins (username, password) VALUES ('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "')");
    }
    
    // OTP Functions
    function generate_otp() {
        return sprintf('%06d', mt_rand(1, 999999));
    }
    
    function send_sms_otp($mobile, $otp) {
        global $pdo;
        // FREE SMS PLACEHOLDER - User to replace with real API (Twilio, etc.)
        // Example Twilio:
        // require_once 'vendor/autoload.php';
        // $client = new Twilio\Rest\Client('SID', 'TOKEN');
        // $client->messages->create("+91$mobile", ['from' => 'FROM_NUMBER', 'body' => "Your CCZ OTP: $otp"]);
        
        // Log for testing (check DB)
        error_log("OTP $otp sent to $mobile (placeholder)");
        return true; // Simulate success
    }
    
    function set_customer_otp($customer_id, $otp) {
        global $pdo;
        $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $stmt = $pdo->prepare("UPDATE customers SET otp = ?, otp_expires = ? WHERE id = ?");
        $stmt->execute([$otp, $expires, $customer_id]);
    }
    
    function verify_customer_otp($identifier, $otp) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE (email = ? OR mobile = ?) AND otp = ? AND otp_expires > datetime('now')");
        $stmt->execute([$identifier, $identifier, $otp]);
        $customer = $stmt->fetch();
        if ($customer) {
            // Clear OTP
            $stmt_clear = $pdo->prepare("UPDATE customers SET otp = NULL, otp_expires = NULL WHERE id = ?");
            $stmt_clear->execute([$customer['id']]);
            return $customer;
        }
        return false;
    }
    
} catch(PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>
