<?php
require 'backend/db.php';
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$uid = $_SESSION['user_id'];
$err = $msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name']);
  $email = trim($_POST['email']);
  $dob = $_POST['dob'] ?: NULL;
  $education_level = $_POST['education_level'];
  $ielts_score = $_POST['ielts_score'];
  $city = $_POST['city'];
  $nationality = $_POST['nationality'];
  $about = $_POST['about'];

  // upsert profile
  $check = $conn->prepare("SELECT id FROM user_profiles WHERE user_id = ?");
  $check->bind_param('i', $uid); $check->execute(); $check->store_result();
  if ($check->num_rows > 0) {
    $upd = $conn->prepare("UPDATE user_profiles SET full_name=?, email=?, dob=?, education_level=?, ielts_score=?, city=?, nationality=?, about=?, updated_at=NOW() WHERE user_id=?");
    $upd->bind_param('ssssssssi',$full_name,$email,$dob,$education_level,$ielts_score,$city,$nationality,$about,$uid);
    if ($upd->execute()) $msg = 'Profile updated successfully.';
    else $err = 'Update failed.';
  } else {
    $ins = $conn->prepare("INSERT INTO user_profiles (user_id, full_name, email, dob, education_level, ielts_score, city, nationality, about) VALUES (?,?,?,?,?,?,?,?,?)");
    $ins->bind_param('issssssss',$uid,$full_name,$email,$dob,$education_level,$ielts_score,$city,$nationality,$about);
    if ($ins->execute()) $msg = 'Profile created.';
    else $err = 'Save failed.';
  }
  $check->close();
}

// fetch profile
$profile = null;
$stm = $conn->prepare("SELECT full_name,email,dob,education_level,ielts_score,city,nationality,about FROM user_profiles WHERE user_id = ?");
$stm->bind_param('i',$uid);
$stm->execute();
$res = $stm->get_result();
if ($res->num_rows>0) $profile = $res->fetch_assoc();
$stm->close();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Profile - StudyPath</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include "components/navbar.php"; ?>
<div class="container my-5">
  <h3>My Profile</h3>
  <?php if($err) echo "<div class='alert alert-danger'>$err</div>"; ?>
  <?php if($msg) echo "<div class='alert alert-success'>$msg</div>"; ?>
  <div class="card-neon" style="max-width:800px">
    <form method="post">
      <div class="row">
        <div class="col-md-6 mb-3"><label>Full name</label><input name="full_name" class="form-control" value="<?=htmlspecialchars($profile['full_name'] ?? '')?>"></div>
        <div class="col-md-6 mb-3"><label>Email</label><input name="email" type="email" class="form-control" value="<?=htmlspecialchars($profile['email'] ?? '')?>"></div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-3"><label>Date of birth</label><input name="dob" type="date" class="form-control" value="<?=htmlspecialchars($profile['dob'] ?? '')?>"></div>
        <div class="col-md-4 mb-3"><label>Education level</label><input name="education_level" class="form-control" value="<?=htmlspecialchars($profile['education_level'] ?? '')?>"></div>
        <div class="col-md-4 mb-3"><label>IELTS score</label><input name="ielts_score" class="form-control" value="<?=htmlspecialchars($profile['ielts_score'] ?? '')?>"></div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3"><label>City</label><input name="city" class="form-control" value="<?=htmlspecialchars($profile['city'] ?? '')?>"></div>
        <div class="col-md-6 mb-3"><label>Nationality</label><input name="nationality" class="form-control" value="<?=htmlspecialchars($profile['nationality'] ?? '')?>"></div>
      </div>
      <div class="mb-3"><label>About / Notes</label><textarea name="about" class="form-control"><?=htmlspecialchars($profile['about'] ?? '')?></textarea></div>
      <button class="btn" style="background:var(--neon)">Save Profile</button>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
