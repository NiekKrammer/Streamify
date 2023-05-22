<?php
// Connect to database
require_once('dbconnect.php');

// Check if form was submitted
if (isset($_POST["submit"])) {
	// Get video file info
	$filename = $_FILES["fileToUpload"]["name"];
	$filetype = $_FILES["fileToUpload"]["type"];
	$tmpname = $_FILES["fileToUpload"]["tmp_name"];

	// Check if file is a video
	if (strpos($filetype, "video") === 0) {
		// Set upload directory
		$upload_dir = "videos";

		// Create directory if it doesn't exist
		if (!file_exists($upload_dir)) {
			mkdir($upload_dir);
		}

		// Generate video filename (video1, video2 etc)
		$counter = 1;
		do {
			$unique_filename = "video" . $counter . ".mp4";
			$counter++;
		} while (file_exists($upload_dir . "/" . $unique_filename));

		// Upload file to server
		move_uploaded_file($tmpname, $upload_dir . "/" . $unique_filename);

		// Add video info to database
		$stmt = $pdo->prepare("INSERT INTO videos (filename, filepath, fileformat, uploaded_at) VALUES (:filename, :filepath, :fileformat, NOW())");
		$stmt->bindParam(":filename", $unique_filename);
		$stmt->bindParam(":filepath", $upload_dir);
		$stmt->bindParam(":fileformat", $filetype);
		$stmt->execute();

		// Redirect back to admin page
		header("Location: homepageAdmin.php");
		exit();
	} else {
		echo "Error: File is not a video";
		header("Location: homepageAdmin.php");
		exit();
	}
}
?>