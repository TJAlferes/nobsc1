<?php

require '../starter.php';

function uploadEquipmentImage() {
	
	// 1. setup
	$temporaryName = $_FILES['submitted_image']['tmp_name'];
	$imageName = $_FILES['submitted_image']['name'];
	$imageDirectory = '../images/equipment/';
	$imagePath = $imageDirectory . $imageName;
	$uploadReady = 1;
	
	
	// 2. check if image type is allowed
	$imageCheck = getimagesize($temporaryName);
	$allowedImageTypes = array(IMAGETYPE_JPEG);
	if (!in_array($imageCheck[2], $allowedImageTypes)) {
		exec('submitted_image -bi ' . $temporaryName, $imageCheck);
	}
	
	
	// 3. check image dimensions
	$imageWidth = $imageCheck[0];
	$imageHeight = $imageCheck[1];
	if (($imageWidth != "480") && ($imageHeight != "320")) {
		return '<div class="image_feedback">Image dimensions must be 480 pixels wide and 320 pixels high.</div>';
		$uploadReady = 0;
	}
	
	
	// 4. check file size
	$maxFileSize = 1000000;  // 1MB
	if (filesize($temporaryName) > $maxFileSize) {
		return '<div class="image_feedback">Image file size is too large.</div>';
		$uploadReady = 0;
	}
	
	
	// 5. check if file already exists
	$targetDirectory = '../images/equipment/';
	$targetFile = $targetDirectory . basename($_FILES['submitted_image']['name']);
	if (file_exists($targetFile)) {
		return '<div class="image_feedback">Image file already exists.</div>';
		$uploadReady = 0;
	}
	
	
	// 6. store the image file in the images/equipment directory
	if ($uploadReady == 1) {
		if (move_uploaded_file($temporaryName, $targetFile)) {
			chmod($targetFile, 0644);
			return '<div class="image_feedback">Image uploaded!</div>';
		} else {
			return '<div class="image_feedback">There was a problem storing your image. Try again?</div>';
		}
	}
	
	
	// 7. make a copy of the image file, resized and name appended with a "-t", store in the images/equipment/thumbs directory
	if (is_uploaded_file($temporaryName)) {
		
		$thumbDirectory = '../images/equipment/thumbs/';
		$thumbName = substr_replace($imageName, '-t.jpg', -4); // change this to prepended with a "tn_"
		$thumbPath = $thumbDirectory . $thumbName;
		$thumbWidth = '120';
		$thumbHeight = '80';
		$thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
		$image = imagecreatefromjpeg($imagePath);
		
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $imageWidth, $imageHeight);
		imagejpeg($thumb, $thumbPath, 100);
		imagedestroy($thumb);
		
	}
	
	
	// 8. finally, make database insertions
	if (is_uploaded_file($temporaryName)) {
		
		$equipmentTypeID = $_POST['equipment_type'];
		$equipmentName = $_POST['equipment_name'];  // sanitize/validate???
		$equipmentDescription = $_POST['equipment_description'];  // sanitize/validate???
		$equipmentImage = $imageName;
		
		$sql = 'INSERT INTO nobsc_equipment (equipment_name, equipment_type_id, equipment_description, equipment_image)
			VALUES (:name, :typeID, :description, :image)';
		global $conn;
		$stmt = $conn->prepare($sql);
		$stmt->execute([':name'        => $equipmentName,
						':typeID'      => $equipmentTypeID,
						':description' => $equipmentDescription,
						':image'       => $equipmentImage]);
		
	}
	
}

if (!empty($_FILES)) {  // TO DO: change this
	echo uploadEquipmentImage();
}

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>COOK EAT WIN REPEAT</title>
	<link href="../../images/master/nobsc-favicon-usa.png" rel="shortcut icon">
	<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
	<link href="../../css/primary.css" rel="stylesheet">
	<link href="../../css/header_white.css" rel="stylesheet">
	<link href="../../css/submit_equipment.css" rel="stylesheet">
</head>
<body>

	<?php require '../content/header_white.php'; ?>
	
	<main>
		<div id="page">
			<form action="" method="post" enctype="multipart/form-data">
				<h1>Submit Kitchen Equipment</h1>
				<div>
					<label>Equipment Type</label>
					<select name="equipment_type">
						<option value="1">Preparing</option>
						<option value="2">Cooking</option>
						<option value="3">Dining</option>
						<option value="4">Cleaning</option>
						<option value="5">Storage</option>
					</select>
				</div>
				<div>
					<label>Equipment Image</label>
					<div id="preview">
						<img src="" id="preview_image">
					</div>
					<input type="file" name="submitted_image" id="submitted_image">
				</div>
				<div>
					<label>Equipment Name</label>
					<input type="text" name="equipment_name">
				</div>
				<div>
					<label>Equipment Description</label>
					<input type="text" name="equipment_description">
				</div>
				<div>
					<!-- TO DO: prevent double submission -->
					<input type="submit" name="submit" id="submit_button" value="Submit Equipment">
				</div>
			</form>
		</div>
	</main>
	
	<?php require '../content/footer_white.php'; ?>
	
	<!-- TO DO: make external -->
	<script>
	document.getElementById("submitted_image").onchange = function () {
		var reader = new FileReader();
		reader.onload = function(e) {
			var image = new Image();
			image.src = e.target.result;
			image.onload = function() {
				var width = this.width;
				var height = this.height;
				if ((width != 480) || (height != 320)) {
					alert("Image dimensions must be 480 pixels wide and 320 pixels high.");
				} else {
				document.getElementById("preview_image").src = e.target.result;
				}
			}
		}
		reader.readAsDataURL(this.files[0]);
	}
	</script>
	
</body>
</html>