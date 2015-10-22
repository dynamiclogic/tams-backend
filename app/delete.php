<?php 
	include 'config.php';
	include 'database.php';

	$assetId = 0;
	
	if ( !empty($_GET['asset_id'])) {
		$assetId = $_REQUEST['asset_id'];
	}

	if ( !empty($_POST)) {
		// keep track post values
		$assetId = $_POST['asset_id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM assets  WHERE asset_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($assetId));
		Database::disconnect();
		header("Location: home.php");
		
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="<?php echo skin;?>css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Delete an Asset</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="delete.php" method="post">
	    			  <input type="hidden" name="assetId" value="<?php echo $assetId;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="home.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>