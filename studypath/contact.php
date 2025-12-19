
<!doctype html><html><head>
<meta charset="utf-8"><title>Contact - StudyPath</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head><body>
<?php include "components/navbar.php"; ?>
<div class="container my-5">
  <h3>Contact Us</h3>
  <div class="card-neon" style="max-width:700px">
    <form action="backend/contact_submit.php" method="post">
      <div class="mb-3"><input name="name" class="form-control" placeholder="Your name" required></div>
      <div class="mb-3"><input name="email" type="email" class="form-control" placeholder="Email" required></div>
      <div class="mb-3"><textarea name="message" class="form-control" placeholder="Message" rows="5" required></textarea></div>
      <button class="btn" style="background:var(--neon)">Send Message</button>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
<footer>
  <div class="container text-center">
    <p class="small">Phone: +880123456789 • Email: info@studypath.example</p>
    <p class="small">Instagram • Facebook</p>
    <p class="small">Address: Independent University, Bangladesh</p>
  </div>
</footer>