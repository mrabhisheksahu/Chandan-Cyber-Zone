<?php
session_start();
include 'config.php';
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

$doc_type = $_GET['doc'] ?? 'Document Order';
$price = 139.00;
$success = '';


if (isset($_GET['pay_done'])) {
    $order_id = (int)$_GET['pay_done'];
    $stmt = $pdo->prepare("UPDATE orders SET status='Paid' WHERE id = ? AND customer_id = ?");
    $stmt->execute([$order_id, $_SESSION['customer_id']]);
    if ($stmt->rowCount() > 0) {
        header('Location: order_success.php?order_id=' . $order_id);
    } else {
        $success = 'Error updating payment status.';
    }
    exit;
}

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

    $success = 'Order submitted successfully! Order ID: ' . $pdo->lastInsertId() . ' (Status: Pending payment)';
} 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order - <?php echo htmlspecialchars($doc_type); ?></title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: Cambria, "Times New Roman", serif;
        background:
          radial-gradient(
            circle at top left,
            rgba(255, 153, 51, 0.15),
            transparent 26%
          ),
          radial-gradient(
            circle at top right,
            rgba(19, 136, 8, 0.14),
            transparent 24%
          ),
          linear-gradient(135deg, #07131f 0%, #0b2238 45%, #12385d 100%);
        min-height: 100vh;
        color: #fff;
      }
      .top-strip {
        width: 100%;
        background: linear-gradient(90deg, #ff9933, #ffffff, #138808);
        color: #091a2f;
        text-align: center;
        font-weight: 800;
        padding: 7px 10px;
        font-size: 13px;
      }
      .header {
        text-align: center;
        padding: 14px 10px 6px;
        font-size: 31px;
        font-weight: 900;
        letter-spacing: 2px;
      }
      .sub-title {
        text-align: center;
        color: #d8e8ff;
        font-size: 15px;
        margin-bottom: 14px;
      }
      .wrapper {
        width: min(1020px, 95%);
        margin: 0 auto 24px;
      }
      .order-card {
        background:
          linear-gradient(
            180deg,
            rgba(255, 255, 255, 0.08),
            rgba(255, 255, 255, 0.03)
          ),
          linear-gradient(145deg, #0a2038, #12355d 68%, #173f70);
        border: 1px solid rgba(192, 192, 192, 0.45);
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.35);
      }
      .card-head {
        background: linear-gradient(
          90deg,
          rgba(180, 190, 200, 0.2),
          rgba(255, 255, 255, 0.08),
          rgba(150, 165, 180, 0.2)
        );
        padding: 14px 18px;
        border-bottom: 1px solid rgba(192, 192, 192, 0.35);
      }
      .card-head h2 {
        font-size: 24px;
        font-weight: 900;
        text-align: center;
        color: #fff;
      }
      .card-head p {
        text-align: center;
        color: #dce9ff;
        margin-top: 4px;
        font-size: 14px;
      }
      .form-body {
        padding: 16px;
      }
      .alert {
        padding: 11px 14px;
        border-radius: 12px;
        margin-bottom: 14px;
        font-size: 15px;
        font-weight: 700;
        background: rgba(40, 167, 69, 0.2);
        border: 1px solid rgba(40, 167, 69, 0.5);
        color: #d4edda;
      }
      .doc-chip-wrap {
        text-align: center;
        margin-bottom: 10px;
      }
      .doc-chip {
        display: inline-block;
        padding: 7px 15px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(192, 192, 192, 0.4);
        color: #fff;
        font-weight: 800;
        font-size: 14px;
      }
      .price-chip {
        display: inline-block;
        margin-top: 8px;
        padding: 8px 16px;
        border-radius: 999px;
        background: linear-gradient(180deg, #ffe28a, #ffb300);
        color: #08203a;
        font-weight: 900;
      }
      .section-title {
        margin: 10px 0 10px;
        font-size: 17px;
        font-weight: 900;
        color: #fff;
        padding-left: 9px;
        border-left: 4px solid #b0b7c3;
      }
      .upload-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 10px;
      }
      .upload-card {
        background: linear-gradient(
          180deg,
          rgba(255, 255, 255, 0.08),
          rgba(255, 255, 255, 0.03)
        );
        border: 1px solid rgba(176, 183, 195, 0.55);
        border-radius: 16px;
        padding: 12px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.22);
      }
      .upload-card h3 {
        text-align: center;
        font-size: 17px;
        margin-bottom: 10px;
        font-weight: 900;
        color: #fff;
      }
      .inner-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
      }
      .field {
        margin-bottom: 12px;
      }
      label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 800;
        color: #fff;
      }
      .input,
      .textarea,
      .file-input {
        width: 100%;
        border: none;
        outline: none;
        border-radius: 12px;
        padding: 10px 11px;
        font-size: 14px;
        font-family: Cambria, "Times New Roman", serif;
        background: #f7fbff;
        color: #0b1a2f;
      }
      .textarea {
        min-height: 78px;
        resize: vertical;
      }
      .file-note {
        color: #d9e8ff;
        font-size: 12px;
        margin-top: 5px;
        line-height: 1.3;
      }
      .preview-box {
        margin-top: 8px;
        width: 100%;
        height: 105px;
        background: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }
      .preview-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: none;
      }
      .preview-text {
        color: #666;
        font-size: 12px;
        text-align: center;
        padding: 8px;
      }
      .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
      }
      .grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
      }
      .btn-row {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 10px;
        flex-wrap: wrap;
      }
      .btn {
        min-width: 165px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 16px;
        border: none;
        border-radius: 13px;
        font-size: 15px;
        font-weight: 900;
        font-family: Cambria, "Times New Roman", serif;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.25s ease;
      }
      .btn-submit {
        color: #111;
        background: linear-gradient(135deg, #ffd86f, #ffb300);
        box-shadow: 0 10px 18px rgba(0,0,0,0.22);
      }
      .btn-submit:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ffe28f, #ffc933);
      }
      .btn-back {
        color: #fff;
        background: linear-gradient(180deg, #5b6875, #3f4c59);
      }
      .or-text {
        text-align: center;
        color: #dbe6f7;
        font-size: 13px;
        font-weight: 700;
        margin-top: 8px;
      }
      @media (max-width: 900px) {
        .upload-grid,
        .grid-2,
        .grid-3,
        .inner-grid {
          grid-template-columns: 1fr;
        }
      }
      @media (max-width: 768px) {
        .header {
          font-size: 24px;
        }
        .btn {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <div class="top-strip">
      FAST DOCUMENT PRINT • SECURE UPLOAD • EASY ORDER PROCESS
    </div>
    <div class="header">CHANDAN CYBER ZONE</div>
    <div class="sub-title">After payment order status stays Pending</div>
    <div class="wrapper">
      <div class="order-card">
        <div class="card-head">
          <h2>Order Section</h2>
          <p>Upload Front + Back image together or upload PDF</p>
        </div>
        <div class="form-body">
<?php if ($success): ?>
          <div class="alert"><?php echo htmlspecialchars($success); ?></div>
          <?php if (isset($order_id)): ?>
          <div class="payment-section" style="background: linear-gradient(135deg, #28a745, #20c997); padding:20px; border-radius:15px; margin:15px 0; text-align:center;">
            <h3 style="color:#fff; margin-bottom:15px;">Pay ₹<?php echo number_format($price, 2); ?></h3>
            <p style="color:#fff; margin-bottom:20px;">Order ID: #<?php echo $order_id; ?></p>
            <div style="display:flex; flex-direction:column; align-items:center; gap:15px;">
              <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRkZGRkZGIi8+Cjx0ZXh0IHg9IjEwMCIgeT0iMTAwIiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMTIiIGZpbGw9IiMwMDYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIwLjNlbSI+4Ki14KbZhSDphJDDgixCIFJldmlldyBQYXltZW50PC90ZXh0Pgo8L3N2Zz4K" alt="UPI QR Code" style="width:200px; height:200px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
              <a href="upi://pay?pa=chandancyber@ybl&pn=Chandan%20Cyber%20Zone&am=139&cu=INR&tn=Order%20%23<?php echo $order_id; ?>&tr=Printing%20Service" style="background:#8258fa; color:#fff; padding:12px 25px; border-radius:25px; font-weight:bold; text-decoration:none;">Open UPI App</a>
              <form method="post" action="?pay_done=<?php echo $order_id; ?>" style="margin:0;">
                <button type="submit" style="background:linear-gradient(135deg, #ffc107, #ff9800); color:#111; border:none; padding:12px 30px; border-radius:25px; font-weight:bold; cursor:pointer; font-size:16px;">Payment Done ✓</button>
              </form>
            </div>
            <p style="color:#fff; font-size:14px; margin-top:15px;">Scan QR or click link, pay ₹139, then click Payment Done</p>
          </div>
          <?php endif; ?>
          <?php endif; ?>
          <div class="doc-chip-wrap">
            <div class="doc-chip"><?php echo htmlspecialchars($doc_type); ?></div>
            <br />
            <div class="price-chip">Printing Charge ₹<?php echo number_format($price, 2); ?>.00</div>
          </div>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="document_type" value="<?php echo htmlspecialchars($doc_type); ?>" />
            <div class="section-title">Document Upload</div>
            <div class="upload-grid">
              <div class="upload-card">
                <h3>Front & Back Upload</h3>
                <div class="inner-grid">
                  <div class="field">
                    <label>Front Image</label>
                    <input
                      class="file-input"
                      type="file"
                      name="front_image"
                      id="front_image"
                      accept=".jpg,.jpeg,.png,.webp"
                    />
                    <div class="file-note">JPG, JPEG, PNG, WEBP</div>
                    <div class="preview-box">
                      <img id="front_preview" alt="Front Preview" />
                      <div class="preview-text" id="front_text">
                        Front Preview
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label>Back Image</label>
                    <input
                      class="file-input"
                      type="file"
                      name="back_image"
                      id="back_image"
                      accept=".jpg,.jpeg,.png,.webp"
                    />
                    <div class="file-note">JPG, JPEG, PNG, WEBP</div>
                    <div class="preview-box">
                      <img id="back_preview" alt="Back Preview" />
                      <div class="preview-text" id="back_text">
                        Back Preview
                      </div>
                    </div>
                  </div>
                </div>
                <div class="or-text">
                  Upload both front and back image together
                </div>
              </div>
              <div class="upload-card">
                <h3>PDF Upload</h3>
                <div class="field">
                  <label>PDF File</label>
                  <input
                    class="file-input"
                    type="file"
                    name="pdf_file"
                    accept=".pdf"
                  />
                  <div class="file-note">Only PDF file allowed</div>
                  <div class="preview-box">
                    <div class="preview-text">Upload single PDF file here</div>
                  </div>
                </div>
                <div class="or-text">
                  If PDF available then image upload optional
                </div>
              </div>
            </div>
            <div class="section-title">Shipping Details</div>
            <div class="grid-2">
              <div class="field">
                <label>Full Name</label>
                <input
                  class="input"
                  type="text"
                  name="full_name"
                  value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>"
                  required
                />
              </div>
              <div class="field">
                <label>Mobile Number</label>
                <input
                  class="input"
                  type="text"
                  name="mobile"
                  maxlength="10"
                  value="<?php echo htmlspecialchars($_POST['mobile'] ?? ''); ?>"
                  required
                />
              </div>
            </div>
            <div class="field">
              <label>Address</label>
              <textarea class="textarea" name="address" required><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
            </div>
            <div class="grid-3">
              <div class="field">
                <label>City</label>
                <input
                  class="input"
                  type="text"
                  name="city"
                  value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>"
                  required
                />
              </div>
              <div class="field">
                <label>State</label>
                <input
                  class="input"
                  type="text"
                  name="state"
                  value="<?php echo htmlspecialchars($_POST['state'] ?? ''); ?>"
                  required
                />
              </div>
              <div class="field">
                <label>Pincode</label>
                <input
                  class="input"
                  type="text"
                  name="pincode"
                  maxlength="6"
                  value="<?php echo htmlspecialchars($_POST['pincode'] ?? ''); ?>"
                  required
                />
              </div>
            </div>
            <div class="btn-row">
              <button type="submit" class="btn btn-submit">
                Pay ₹<?php echo number_format($price, 2); ?>.00 & Submit Order
              </button>
<a href="index.php" class="btn btn-back">Back to Home</a>
            </div>
            </form>
        </div>
      </div>
    </div>
    <script>
      function imagePreview(inputId, imageId, textId) {
        const input = document.getElementById(inputId),
          image = document.getElementById(imageId),
          text = document.getElementById(textId);
        if (!input) return;
        input.addEventListener("change", function () {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
              image.src = e.target.result;
              image.style.display = "block";
              text.style.display = "none";
            };
            reader.readAsDataURL(file);
          } else {
            image.src = "";
            image.style.display = "none";
            text.style.display = "block";
          }
        });
      }
      imagePreview("front_image", "front_preview", "front_text");
      imagePreview("back_image", "back_preview", "back_text");
    </script>
  </body>
</html>
