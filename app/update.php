<?php 
	include '../config.php';
	include 'db_functions.php';

	$asset_id = 0;

	if ( !empty($_GET['asset_id'])) {
		$asset_id = $_REQUEST['asset_id'];
	}
	
	if ( null==$asset_id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$descriptionError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$description = $_POST['description'];
		
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
		// update data
		if ($valid) {
			$db = new DB_Functions();
			$db->updateAsset($asset_id, $name, $description);
			header("Location: index.php");
		}
	} else {
		$db = new DB_Functions();
		$asset = $db->getAssetById($asset_id);
		$name = $asset['name'];
		$description = $asset['description'];
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link   href="<?php echo skin;?>css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update an Asset</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?asset_id=<?php echo $asset_id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="description" type="text" placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="home.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>