<?php
require 'backend/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $phone = trim($_POST['phone']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE phone = ?");
  $stmt->bind_param('s', $phone);
  $stmt->execute();
  $stmt->bind_result($id, $hash);
  if ($stmt->fetch() && password_verify($password, $hash)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['phone'] = $phone;
    header('Location: profile.php');
    exit;
  } else {
    $err = 'Invalid phone or password.';
  }
  $stmt->close();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><title>Login - StudyPath</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include "components/navbar.php"; ?>
<div class="container my-5">
  <h3>Login</h3>
  <?php if(!empty($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>
  <div class="card-neon" style="max-width:520px;">
    <form method="post">
      <div class="mb-3"><label>Phone number</label><input name="phone" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
      <button class="btn" style="background:var(--neon)">Login</button>
    </form>
    <div class="mt-2"><small>Don't have an account? <a href="register.php">Register</a></small></div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
