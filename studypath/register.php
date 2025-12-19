<?php
require 'backend/db.php';
session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $phone = trim($_POST['phone']);
  $password = $_POST['password'];
  if (!preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) {
    $err = 'Please enter a valid phone number.';
  } elseif (strlen($password) < 6) {
    $err = 'Password must be at least 6 characters.';
  } else {
    // check exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $err = 'Phone already registered. Please login.';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $ins = $conn->prepare("INSERT INTO users (phone, password_hash) VALUES (?, ?)");
      $ins->bind_param('ss', $phone, $hash);
      if ($ins->execute()) {
        // auto-login
        $uid = $ins->insert_id;
        $_SESSION['user_id'] = $uid;
        $_SESSION['phone'] = $phone;
        header('Location: profile.php');
        exit;
      } else $err = 'Registration failed. Try again.';
    }
    $stmt->close();
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><title>Register - StudyPath</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include "components/navbar.php"; ?>
<div class="container my-5">
  <h3 class="mb-3">Create Account</h3>
  <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
  <div class="card-neon" style="max-width:520px;">
    <form method="post">
      <div class="mb-3"><label>Phone number</label>
        <input name="phone" class="form-control" required></div>
      <div class="mb-3"><label>Password</label>
        <input name="password" type="password" class="form-control" required></div>
      <div class="mb-3">
        <button class="btn" style="background:var(--neon)">Create account</button>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
