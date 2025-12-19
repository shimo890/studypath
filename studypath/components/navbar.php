<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$logged = isset($_SESSION['user_id']);
$displayName = $logged ? ($_SESSION['name'] ?? $_SESSION['phone']) : null;
?>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="/studypath/index.php">StudyPath</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span>☰</span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/studypath/countries.php">Countries</a></li>
        <li class="nav-item"><a class="nav-link" href="/studypath/scholarships.php">Scholarships</a></li>
        <li class="nav-item"><a class="nav-link" href="/studypath/contact.php">Contact</a></li>
      </ul>

      <!-- Search bar -->
      <div class="d-flex flex-grow-1 me-3 position-relative">
        <input id="globalSearch" class="search-input" type="search" placeholder="Search countries, universities, scholarships..." aria-label="Search">
        <div id="searchResultsBox" class="search-results" style="display:none;"></div>
      </div>

      <!-- Profile Icon / Dropdown -->
      <div class="ms-2">
        <?php if($logged): ?>
          <div class="dropdown">
            <button class="profile-btn dropdown-toggle" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="profile-avatar"><?= htmlspecialchars($displayName[0] ?? '👤') ?></div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="/studypath/profile.php">My Profile</a></li>
              <li><a class="dropdown-item" href="/studypath/logout.php">Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <div class="dropdown">
            <button class="profile-btn dropdown-toggle" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="profile-avatar">👤</div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end p-3" style="min-width:260px">
              <form action="/studypath/login.php" method="post">
                <div class="mb-2">
                  <input name="phone" class="form-control" placeholder="Phone number" required>
                </div>
                <div class="mb-2">
                  <input name="password" type="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="d-flex justify-content-between">
                  <button class="btn btn-sm" type="submit" style="background:var(--neon);">Login</button>
                  <a class="btn btn-outline-secondary btn-sm" href="/studypath/register.php">Register</a>
                </div>
              </form>
            </ul>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</nav>
