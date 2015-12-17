<?php 
include '../config.php';
include 'db_functions.php';

if ( !empty($_POST)) {
		// keep track validation errors
	$nameError = null;
	$descriptionError = null;

		// keep track post values
	$name = $_POST['name'];
	$description = $_POST['description'];
	$longitude = $_POST['longitude'];
	$latitude = $_POST['latitude'];
	$images = $_POST['images'];
	$voice_memo = $_POST['voice_memo'];

		// validate input
	$valid = true;
	if (empty($name)) {
		$nameError = 'Please enter Name';
		$valid = false;
	}

	if (empty($description)) {
		$descriptionError = 'Please enter Description';
		$valid = false;
	}

	// insert data
	if ($valid) {
		//Create Object for DB_Functions clas
		$db = new DB_Functions();
		$db->addAsset($name, $description, $latitude, $longitude, $images);
		header("Location: index.php");
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<!--<script src="../js/jquery-1.11.2.min.js"></script>-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="../js/dropzone.js"></script>
	<link href="<?php echo skin;?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo skin;?>css/styles.css" rel="stylesheet" >
	<script src="../js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">

		<div class="span10 offset1">
			<div class="row">
				<h3>Create an Asset</h3>
			</div>
			<form id="form1" enctype="multipart/form-data" method="post" action="Upload.php">
					<div id="draghere">
						<input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();uploadFile();" accept="image/*" capture="camera"/>
					</div>
				<div id="details"></div>
				<div id="progress"></div>
			</form>
			<form class="form-horizontal" action="create.php" method="post">
				<div class="form-group <?php echo !empty($nameError)?'has-error':'';?>">
					<label class="control-label" for="inputDefault">Name</label>
					<input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>" type="text" class="form-control" id="<?php echo !empty($nameError)?'inputError':'inputDefault';?>">
					<?php if (!empty($nameError)): ?>
						<span class="help-inline"><?php echo $nameError;?></span>
					<?php endif;?>
				</div>

				<input name="images" type="hidden" value="test" id="image-file">

				<div class="form-group <?php echo !empty($descriptionError)?'has-error':'';?>">
					<label class="control-label" for="inputDefault">Description</label>
					<input name="description" type="text" placeholder="Description" value="<?php echo !empty($description)?$description:'';?>" type="text" class="form-control" id="<?php echo !empty($descriptionError)?'inputError':'inputDefault';?>">
					<?php if (!empty($descriptionError)): ?>
						<span class="help-inline"><?php echo $descriptionError;?></span>
					<?php endif;?>
				</div>

				<div class="form-group">
					<label class="control-label">Coordinates <img src="<?php echo skin;?>img/loading.gif" class="loading" id="spinner"/></label>
					<div class="input-group">
						<span class="input-group-addon">Lat:</span>
						<input name="latitude" type="text" id="lat" class="form-control" placeholder="Latitude" value="<?php echo !empty($latitude)?$latitude:'';?>">

						<span class="input-group-addon">Long:</span>
						<input name="longitude" type="text" id="lon" class="form-control" placeholder="Longitude" value="<?php echo !empty($longitude)?$longitude:'';?>">
					</div>

				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-success">Create</button>
				<a class="btn btn-default" href="home.php">Back</a>
			</div>
		</form>
	</div>

	<!-- Get Location -->
	<script>
		$(function() {
			document.getElementById("spinner").style.display = "-webkit-inline-box";
			var lat = document.getElementById("lat");
			var lon = document.getElementById("lon");

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {
				x.innerHTML = "Geolocation is not supported by this browser.";
			}
		});
		function showPosition(position) {
			lat.value = position.coords.latitude;
			lon.value = position.coords.longitude;
			document.getElementById("spinner").style.display = "none";

		}
	</script>
	<!-- /Get Location -->

	<!-- File Upload -->
	<script type="text/javascript">
		function fileSelected() {
			var count = document.getElementById('fileToUpload').files.length;
			document.getElementById('details').innerHTML = "";
			for (var index = 0; index < count; index ++)
			{
				var file = document.getElementById('fileToUpload').files[index];
				var fileSize = 0;
				if (file.size > 1024 * 1024)
					fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
				else
					fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
				//document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
				//document.getElementById('details').innerHTML += '<p>';
				document.getElementById('image-file').value = '../media/' + file.name;
			}
		}

		function uploadFile() {
			var fd = new FormData();
			var count = document.getElementById('fileToUpload').files.length;
			var file = "";
			for (var index = 0; index < count; index ++) {
				file = document.getElementById('fileToUpload').files[index];
				fd.append('myFile', file);
			}
			var xhr = new XMLHttpRequest();
			xhr.upload.addEventListener("progress", uploadProgress, false);
			xhr.addEventListener("load", uploadComplete.bind(null, file), false);
			xhr.addEventListener("error", uploadFailed, false);
			xhr.addEventListener("abort", uploadCanceled, false);
			xhr.open("POST", "savetofile.php");
			xhr.send(fd);
		}

		function uploadProgress(evt) {
			if (evt.lengthComputable) {
				var percentComplete = Math.round(evt.loaded * 100 / evt.total);
				document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
			}
			else {
				document.getElementById('progress').innerHTML = 'unable to compute';
			}
		}

		function uploadComplete(file, evt) {
			/* This event is raised when the server send back a response */
			document.getElementById('draghere').innerHTML = '<img id="image-placeholder" src="' + '../media/' + file.name + '"/>';

		}

		function uploadFailed(evt) {
			alert("There was an error attempting to upload the file."); 
		}

		function uploadCanceled(evt) {
			alert("The upload has been canceled by the user or the browser dropped the connection.");
		}
	</script>	<!-- /File Upload -->

</div> <!-- /container -->
</body>
</html>