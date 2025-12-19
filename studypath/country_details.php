<?php
require "backend/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  header('Location: countries.php');
  exit;
}

// fetch country
$stmt = $conn->prepare("SELECT id, name, short_description FROM countries WHERE id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$country = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$country) {
  header('Location: countries.php');
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($country['name']) ?> – StudyPath</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "components/navbar.php"; ?>

<main class="container my-5">
  <div class="row">
    <div class="col-lg-8">
      <h2 class="fw-bold" style="color:var(--neon-dark)"><?= htmlspecialchars($country['name']) ?></h2>
      <p class="text-muted"><?= nl2br(htmlspecialchars($country['short_description'])) ?></p>

      <hr>

      <h4 class="fw-bold">Top Universities</h4>
      <div class="row g-3">
        <?php
          $stmt = $conn->prepare("SELECT id,name,city,short_description FROM universities WHERE country_id = ? ORDER BY name ASC");
          $stmt->bind_param('i',$id);
          $stmt->execute();
          $res = $stmt->get_result();
          if ($res->num_rows > 0):
            while ($u = $res->fetch_assoc()):
        ?>
          <div class="col-md-6">
            <div class="card-neon p-3 h-100">
              <h5 class="mb-1"><?= htmlspecialchars($u['name']) ?></h5>
              <div class="small text-muted mb-2"><?= htmlspecialchars($u['city']) ?></div>
              <p class="mb-0"><?= htmlspecialchars(substr($u['short_description'],0,160)) ?>...</p>
              <a href="<?= htmlspecialchars($u['website'] ?? '#') ?>" target="_blank" class="small d-block mt-2">Visit Website</a>
            </div>
          </div>
        <?php
            endwhile;
          else:
        ?>
          <div class="col-12"><div class="alert alert-secondary">No universities listed for this country yet.</div></div>
        <?php endif;
          $stmt->close();
        ?>
      </div>

    </div>

    <aside class="col-lg-4">
      <div class="card-neon p-3">
        <h6 class="fw-bold">Visa & Admission Tips</h6>
        <p class="small text-muted">General guidance on student visa processes and typical admission requirements. Always verify with official sources and university pages.</p>
        <a class="btn btn-sm" style="background:var(--neon); font-weight:600" href="contact.php">Ask a Question</a>
      </div>

      <div class="card-neon p-3 mt-3">
        <h6 class="fw-bold">Scholarships in <?= htmlspecialchars($country['name']) ?></h6>
        <?php
          $stmt = $conn->prepare("SELECT id,title,deadline FROM scholarships WHERE country_id = ? ORDER BY deadline ASC LIMIT 5");
          $stmt->bind_param('i',$id);
          $stmt->execute();
          $rs = $stmt->get_result();
          if ($rs->num_rows > 0):
            while ($s = $rs->fetch_assoc()):
        ?>
          <div class="mb-2">
            <a href="scholarship_details.php?id=<?= (int)$s['id'] ?>" class="d-block fw-bold small text-dark"><?= htmlspecialchars($s['title']) ?></a>
            <div class="small text-muted">Deadline: <?= htmlspecialchars($s['deadline'] ?: 'TBA') ?></div>
          </div>
        <?php
            endwhile;
          else:
        ?>
          <div class="small text-muted">No scholarships listed for this country yet.</div>
        <?php endif;
          $stmt->close();
        ?>
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
