<?php 
include 'config.php';
include 'database.php';

if ( !empty($_GET['asset_id'])) {
	$assetId = $_REQUEST['asset_id'];
}

if ( !isset($assetId) ) {
	header("Location: index.php");
} else {
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$sql = "SELECT * FROM assets where asset_id = ?";

	$sql = 'SELECT assets.*,
	attributes.attribute_label,
	attributes_values.attribute_value,
	users.username,
	locations.longitude,
	locations.latitude,
	asset_types.type_value,
	media.images,
	media.voice_memo
	FROM assets 
	LEFT JOIN asset_types ON assets.type_id = asset_types.asset_type_id
	LEFT JOIN attributes_indexes ON assets.asset_id = attributes_indexes.asset_id
	LEFT JOIN attributes ON attributes_indexes.attribute_id = attributes.attribute_id
	LEFT JOIN attributes_values ON attributes_indexes.attribute_value_id = attributes_values.attribute_value_id
	LEFT JOIN users ON assets.user_id = users.user_id
	LEFT JOIN media ON assets.asset_id = media.asset_id
	LEFT JOIN locations ON assets.asset_id = locations.asset_id
	WHERE (assets.asset_id = ?)';


	$q = $pdo->prepare($sql);
	$q->execute(array($assetId));
	$data = $q->fetchall(PDO::FETCH_ASSOC);
	Database::disconnect();
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
				<h3><?php echo $data[0]['name'];?> - ID:<?php echo $data[0]['asset_id'];?></h3>
			</div>

			<div class="col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Image</h3>
					</div>
					<div class="panel-body">
						<img class="asset-image" src="<?php echo $data[0]['images'];?>" />
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
							<?php echo $data[0]['description'];?>
						</div>

						<div class="control-group">
							<label class="control-label">Location:</label>
							Lat:<?php echo $data[0]['latitude'];?>   Long:<?php echo $data[0]['longitude'];?>
						</div>

						<div class="control-group">
							<label class="control-label">Created by:</label>
							<?php echo $data[0]['username'];?>
						</div>

						<div class="control-group">
							<?php foreach ($data as $row): ?>
								<br>
								<?php echo '<strong>' . $row['attribute_label'] .':</strong> '. $row['attribute_value'];?>
							<?php endforeach;?>
						</div>
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
						src="https://www.google.com/maps/embed/v1/search?key=AIzaSyAzCBWqT8X-Gmkohu5UJi7Umkio_wb6mK8&q=<?php echo $data[0]['latitude'];?>,<?php echo $data[0]['longitude'];?>">
					</iframe>
				</div>
			</div>
		</div>

	</div>

</div> <!-- /container -->
</body>
</html>