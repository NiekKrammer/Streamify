<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
  <script src="https://kit.fontawesome.com/34bed6ab1b.js" crossorigin="anonymous"></script>
  <title>streamify</title>
</head>

<body>

  <!-- Navbar -->
  <nav>
    <h1>streamify</h1>

    <input type="checkbox" id="check" class="menu-btn">
    <label for="check" class="menu-icon">
      <span class="navicon"></span></label>

    <ul>
      <li><a href="subscriptions.html" class="nav-link">subscription</a></li>
      <li><a href="logout.php" class="nav-link">logout</a></li>
    </ul>
  </nav>

  <!-- Herosection -->
  <div class="herosection">
    <h2>The Ultimate Video Hosting Site!</h2>
    <p>Stream the Best Videos Online and Explore a World of Entertainment</p>
  </div>

  <!-- Videos display section -->
  <div class="videos">
    <?php
    // Connect to database
    require_once('dbconnect.php');

    // Fetch videos from database
    $videos = $pdo->query("SELECT * FROM videos")->fetchAll(PDO::FETCH_ASSOC);

    // Display videos
    foreach ($videos as $video) {
      echo '<video src="' . $video["filepath"] . '/' . $video["filename"] . '"preload="metadata" controls class="video"></video>';
    }
    ?>
  </div>

  <!-- Footer -->
  <footer>
    <p>© streamify | All Rights Reserved</p>
  </footer>
  <script src="script.js"></script>
</body>

</html>