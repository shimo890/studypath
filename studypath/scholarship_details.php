<?php
require "backend/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: scholarships.php'); exit; }

$stmt = $conn->prepare(
  "SELECT s.*, u.name AS university, c.name AS country
     FROM scholarships s
     LEFT JOIN universities u ON s.university_id = u.id
     LEFT JOIN countries c ON s.country_id = c.id
    WHERE s.id = ? LIMIT 1"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$sch = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$sch) { header('Location: scholarships.php'); exit; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($sch['title']) ?> – StudyPath</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "components/navbar.php"; ?>

<main class="container my-5">
  <div class="row">
    <div class="col-lg-8">
      <h2 class="fw-bold" style="color:var(--neon-dark)"><?= htmlspecialchars($sch['title']) ?></h2>
      <div class="small text-muted mb-3">
        <?= $sch['university'] ? "University: " . htmlspecialchars($sch['university']) . " • " : '' ?>
        <?= $sch['country'] ? "Country: " . htmlspecialchars($sch['country']) . " • " : '' ?>
        Deadline: <?= htmlspecialchars($sch['deadline'] ?: 'TBA') ?>
      </div>

      <h5 class="mt-3">Eligibility</h5>
      <p><?= nl2br(htmlspecialchars($sch['eligibility'] ?: 'Not specified')) ?></p>

      <?php if (!empty($sch['link'])): ?>
        <a class="btn btn-sm" style="background:var(--neon); font-weight:600" href="<?= htmlspecialchars($sch['link']) ?>" target="_blank">Official Page</a>
      <?php endif; ?>
    </div>

    <aside class="col-lg-4">
      <div class="card-neon p-3">
        <h6 class="fw-bold">Related Scholarships</h6>
        <?php
          $stmt = $conn->prepare("SELECT id,title,deadline FROM scholarships WHERE country_id = ? AND id != ? ORDER BY deadline ASC LIMIT 5");
          $stmt->bind_param('ii', $sch['country_id'],$id);
          $stmt->execute();
          $res = $stmt->get_result();
          if ($res->num_rows > 0):
            while ($r = $res->fetch_assoc()):
        ?>
          <div class="mb-2">
            <a href="scholarship_details.php?id=<?= (int)$r['id'] ?>" class="d-block small fw-bold"><?= htmlspecialchars($r['title']) ?></a>
            <div class="small text-muted">Deadline: <?= htmlspecialchars($r['deadline'] ?: 'TBA') ?></div>
          </div>
        <?php
            endwhile;
          else:
        ?>
          <div class="small text-muted">No related scholarships found.</div>
        <?php endif; $stmt->close(); ?>
      </div>
    </aside>
  </div>
</main>

<footer>
  <div class="container text-center">
    <p class="small">Phone: +880123456789 • Email: info@studypath.example</p>
    <p class="small">Instagram • Facebook</p>
    <p class="small">Address: Independent University, Bangladesh</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
