<?php include "components/navbar.php"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>StudyPath – Study Abroad Made Simple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"> 
</head>

<body>

<!-- ================= HERO SECTION ================= -->
<div class="hero-section">
    <div class="hero-overlay">
        <h1 class="fw-bold">Study Abroad Made Simple</h1>
        <p class="fs-5">Find the best countries, universities & scholarships for your future.</p>

        <!-- Search Bar -->
        <form action="search.php" method="GET" class="hero-search">
            <input type="text" name="q" placeholder="Search countries, scholarships, universities..." required>
            <button type="submit"><i class="ri-search-line"></i></button>
        </form>
    </div>
</div>



<!-- ================= FEATURE BLOCKS ================= -->
<div class="container my-5">
    <div class="row g-4">

        <!-- Country Guides -->
        <div class="col-md-4">
            <div class="feature-box" style="background-image: url('assets/images/features/countries.jpg');">
                <i class="ri-earth-line feature-icon"></i>
                <h3>Country Guides</h3>
                <p>Admissions, visas & living costs explained.</p>
                <a href="countries.php" class="btn btn-light btn-sm fw-bold">Explore →</a>
            </div>
        </div>

        <!-- Scholarship Finder -->
        <div class="col-md-4">
            <div class="feature-box" style="background-image: url('assets/images/features/scholarships.jpg');">
                <i class="ri-graduation-cap-line feature-icon"></i>
                <h3>Scholarship Finder</h3>
                <p>Search scholarships by country or field.</p>
                <a href="scholarships.php" class="btn btn-light btn-sm fw-bold">Search →</a>
            </div>
        </div>

        <!-- Profile & Applications -->
        <div class="col-md-4">
            <div class="feature-box" style="background-image: url('assets/images/features/profile.jpg');">
                <i class="ri-user-3-line feature-icon"></i>
                <h3>Profile & Applications</h3>
                <p>Save programs & manage your student profile.</p>
                <a href="profile.php" class="btn btn-light btn-sm fw-bold">View Profile →</a>
            </div>
        </div>

    </div>
</div>



<!-- ================= FOOTER ================= -->
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
