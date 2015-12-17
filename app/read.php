<?php 
include '../config.php';
include 'db_functions.php';

if ( !empty($_GET['asset_id'])) {
	$asset_id = $_REQUEST['asset_id'];
}

if ( !isset($asset_id) ) {
	header("Location: index.php");
} else {
	$db = new DB_Functions();
	$asset = $db->getAssetById($asset_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link   href="<?php echo skin;?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo skin;?>css/styles.css" rel="stylesheet" >
	<script src="../js/jquery-1.11.2.min.js"> </script>
	<script src="../js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">

		<div class="span10 offset1">
			<div class="row" style="margin-left:15px; margin-right: 15px;">
				<div class="form-actions" style="float:right;padding-top: 10px;">
					<a class="btn btn-default" href="home.php">Back</a>
				</div>
				<h3><?php echo $asset['name'];?> - ID:<?php echo $asset['asset_id'];?></h3>
			</div>

			<div class="col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Image</h3>
					</div>
					<div class="panel-body">
						<img class="asset-image" src="data:image/png;base64,<?php echo $asset['images'];?>" />
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Information</h3>
					</div>
					<div class="panel-body">


						<div class="control-group">
							<label class="control-label">Description:</label>
							<?php echo $asset['description'];?>
						</div>

						<div class="control-group">
							<label class="control-label">Location:</label>
							Lat:<?php echo $asset['latitude'];?>   Long:<?php echo $asset['longitude'];?>
						</div>

						<div class="control-group">
							<label class="control-label">Created by:</label>
							<?php echo $asset['username'];?>
						</div>

						<!--<div class="control-group">
							<?php foreach ($asset as $row): ?>
								<br>
								<?php echo '<strong>' . $row['attribute_label'] .':</strong> '. $row['attribute_value'];?>
							<?php endforeach;?>
						</div>-->
					</div>

				</div>

			</div>
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Map</h3>
					</div>
					<div class="panel-body">
						<iframe frameborder="0" style="border:0; width:100%; height:300px"
						src="https://www.google.com/maps/embed/v1/search?key=AIzaSyAzCBWqT8X-Gmkohu5UJi7Umkio_wb6mK8&q=<?php echo $asset['latitude'];?>,<?php echo $asset['longitude'];?>">
					</iframe>
				</div>
			</div>
		</div>

	</div>

</div> <!-- /container -->
</body>
</html>
