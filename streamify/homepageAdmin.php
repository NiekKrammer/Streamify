<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
  <title>streamify</title>
</head>

<body>

  <!-- navbar -->
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
    <p style="color:grey">Stream the Best Videos Online and Explore a World of Entertainment</p>
  </div>

  <!-- Video upload section -->
  <form action="upload.php" method="post" enctype="multipart/form-data" style="margin: 20px;">
    <label style="color: white;">Select video to upload:</label>
    <br />
    <input type="file" name="fileToUpload" id="fileToUpload" style="color: white;" />
    <br />
    <input type="submit" value="Upload" name="submit" />
  </form>


  <!-- Videos display section -->
  <div class="videos">
    <?php
    // Connect to database
    require_once('dbconnect.php');

    // Check if delete button was clicked
    if (isset($_POST["delete"])) {
      // Get video ID from button value
      $video_id = $_POST["delete"];

      // Fetch video info from database
      $stmt = $pdo->prepare("SELECT * FROM videos WHERE id=:id");
      $stmt->bindParam(":id", $video_id);
      $stmt->execute();
      $video = $stmt->fetch(PDO::FETCH_ASSOC);

      // Delete video file from server
      $filepath = $video["filepath"] . '/' . $video["filename"];
      unlink($filepath);

      // Delete video record from database
      $stmt = $pdo->prepare("DELETE FROM videos WHERE id=:id");
      $stmt->bindParam(":id", $video_id);
      $stmt->execute();
    }

    // Fetch videos from database
    $videos = $pdo->query("SELECT * FROM videos")->fetchAll(PDO::FETCH_ASSOC);

    // Display videos
    foreach ($videos as $video) {
      echo '<div>';
      echo '<video src="' . $video["filepath"] . '/' . $video["filename"] . '"preload="metadata" controls class="video"></video>';
      echo '<form method="POST">';
      echo '<button type="submit" name="delete" value="' . $video["id"] . '">Delete</button>';
      echo '</form>';
      echo '</div>';
    }
    ?>
  </div>

  <!-- Footer -->
  <footer>
    <p>© streamify | All Rights Reserved</p>
  </footer>
</body>

</html>