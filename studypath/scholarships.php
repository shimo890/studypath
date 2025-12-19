<?php
require "backend/db.php";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Scholarships – StudyPath</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include "components/navbar.php"; ?>

<main class="container my-5">

  <header class="text-center mb-4">
    <h2 class="fw-bold" style="color: var(--neon-dark)">Scholarships & Funding Opportunities</h2>
    <p class="text-muted">Find scholarships by country and university. Click a scholarship to view full details.</p>
  </header>

  <div class="row g-4">
    <?php
      $sql = "SELECT s.id, s.title, s.eligibility, s.deadline, c.name AS country, u.name AS university
                FROM scholarships s
                LEFT JOIN countries c ON s.country_id = c.id
                LEFT JOIN universities u ON s.university_id = u.id
               ORDER BY COALESCE(s.deadline, '9999-12-31') ASC";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
      <div class="col-md-6">
        <div class="card-neon h-100 p-3">
          <div class="d-flex justify-content-between">
            <div>
              <h5 class="fw-bold mb-1"><?= htmlspecialchars($row['title']) ?></h5>
              <div class="small text-muted">
                <?= $row['university'] ? "University: " . htmlspecialchars($row['university']) . " • " : '' ?>
                <?= $row['country'] ? "Country: " . htmlspecialchars($row['country']) : '' ?>
              </div>
            </div>
            <div class="text-end">
              <div class="small text-muted">Deadline</div>
              <div class="fw-bold"><?= htmlspecialchars($row['deadline'] ?: 'TBA') ?></div>
            </div>
          </div>

          <p class="mt-3"><?= htmlspecialchars(substr($row['eligibility'],0,180)) ?>...</p>

          <div>
            <a href="scholarship_details.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm" style="background:var(--neon); font-weight:600">View Details →</a>
          </div>
        </div>
      </div>
    <?php
        endwhile;
      else:
    ?>
      <div class="col-12"><div class="alert alert-info">No scholarships found. Add data to the database to display here.</div></div>
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
