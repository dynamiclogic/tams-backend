<?php
include "config.php";
include "db_functions.php";
session_start();
if(empty($_SESSION['login_user']))
{
header('Location: index.php');
}

?>

<?php include_once 'header.php'; ?>

    <div class="container">
			<div class="row">
				<div id="top-bar">
					<div id="left" class="column">
						<a href="create.php" class="btn btn-large btn-primary"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Asset</a>
					</div>
		    </div>
		  </div>

			<div class="row">
        		<span id="mobile-assets-table"></span>
				<table class="table table-striped table-bordered" id="assets-table">
		            <thead>
		            	<tr>
                      		<th>Image</th>
		                  	<th>AssetId</th>
		                  	<th>Name</th>
		                  	<th>Description</th>
		                  	<th>Type</th>
		                  	<th>Location</th>
		                  	<th>Created By</th>
		                  	<th colspan="3" align="center">Actions</th>
		                </tr>
		            </thead>
		            <tbody>
		            	<?php 
             				$temp_assets = array();
					   		$db = new DB_Functions();
             				$assets = $db->getActiveAssets();
             			?>

	 					<?php foreach ($assets as $asset):?>
                 			<?php //check for unique results
                 				if (!in_array($asset['asset_id'], $temp_assets)) {
                 			  		$temp_assets[] = $asset['asset_id'];
                 			  	}
                 			?>

                 			<a href="read.php?asset_id=<?php print($asset['asset_id'])?>" class="list-group-item">
                 				<?php if ($asset['images']): ?>
                 					<img class="asset-image-table asset-image-table-mobile" src="data:image/png;base64,<?php print($asset['images']) ?>"/>
                 				<?php endif; ?>
                 				<h4 class="list-group-item-heading">
                 					<?php print($asset['name']); ?>
                 				</h4>
                 				<p class="list-group-item-text"> <?php print($asset['description'])?> </p>
                 			</a>

						   	<tr>
                 				<td>
                 					<?php if ($asset['images']): ?>
                 			  			<img class="asset-image-table" src="data:image/png;base64,<?php print($asset['images'])?>"/>
                 			  		<?php endif; ?>
                 				</td>
							   	<td><?php print($asset['asset_id'])?></td>
							   	<td><?php print($asset['name'])?></td>
							   	<td><?php print($asset['description'])?></td>
							   	<td><?php print($asset['type_value'])?></td>
							   	<td><?php print($asset['longitude'])?><br><?php print($asset['latitude'])?></td>
							   	<td><?php print($asset['created_by'])?></td>
							   	<td align="center">
							   		<a href="read.php?asset_id=<?php print($asset['asset_id'])?>"><i class="glyphicon glyphicon-eye-open"></i></a>
							   	</td>
                 				<td align="center">
							   		<a href="update.php?asset_id=<?php print($asset['asset_id'])?>"><i class="glyphicon glyphicon-edit"></i></a>
							   	</td>
							   	<td align="center">
							   		<a href="delete.php?asset_id=<?php print($asset['asset_id'])?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
							   	</td>
							</tr>
					  	<?php endforeach ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->

<?php include_once 'footer.php'; ?>
