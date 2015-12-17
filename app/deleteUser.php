<?php 
	include '../config.php';
	include 'db_functions.php';

	$user_id = 0;
	
	if ( !empty($_GET['user_id'])) {
		$user_id = $_REQUEST['user_id'];
		
		// delete data
		$db = new DB_Functions();
		$db->deleteUser($user_id);
		header("Location: accounts.php");
		
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
		    		
	    			<form class="form-horizontal" action="deleteUser.php" method="post">
	    			  <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
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