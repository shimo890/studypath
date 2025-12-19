<?php
require "backend/db.php";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Countries – StudyPath</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include "components/navbar.php"; ?>

<main class="container my-5">

  <header class="text-center mb-4">
    <h2 class="fw-bold" style="color: var(--neon-dark)">Study Abroad by Country</h2>
    <p class="text-muted">Explore country guides, visa rules, top universities and scholarship opportunities.</p>
  </header>

  <div class="row g-4">
    <?php
      $sql = "SELECT id, name, short_description FROM countries ORDER BY name ASC";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
      <div class="col-sm-6 col-md-4">
        <a href="country_details.php?id=<?= (int)$row['id'] ?>" class="text-decoration-none">
          <div class="card-neon h-100 p-3">
            <div class="d-flex align-items-start justify-content-between">
              <h4 class="mb-2 fw-bold"><?= htmlspecialchars($row['name']) ?></h4>
              <span class="badge bg-light text-dark" style="border:1px solid rgba(0,0,0,0.06)">Country</span>
            </div>
            <p class="text-muted mb-3"><?= htmlspecialchars(substr($row['short_description'],0,150)) ?>...</p>
            <div>
              <span class="btn btn-sm" style="background:var(--neon); font-weight:600">Learn more →</span>
            </div>
          </div>
        </a>
      </div>
    <?php
        endwhile;
      else:
    ?>
      <div class="col-12">
        <div class="alert alert-info">No countries found. Please add sample data in the database.</div>
      </div>
    <?php endif; ?>
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
