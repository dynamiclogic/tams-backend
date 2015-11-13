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
					<div id="left" class="column"><a href="create.php" class="btn btn-success">Create</a></div>
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
		                  <th>Actions</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
             $temp_assets = array();

					   $db = new DB_Functions();
             $assets = $db->getActiveAssets();

	 				   foreach ($assets as $asset) {
                  //check for unique results
                  if (!in_array($asset['asset_id'], $temp_assets)) {
                    $temp_assets[] = $asset['asset_id'];;

                  echo '<a href="read.php?asset_id='.$asset['asset_id'].'" class="list-group-item">';
                  if ($asset['images']) {
                    echo '<img class="asset-image-table asset-image-table-mobile" src="data:image/png;base64,' . $asset['images'] . '"/>';
                  }
                  echo '<h4 class="list-group-item-heading">';
                  echo $asset['name'];
                  echo '</h4><p class="list-group-item-text">' . $asset['description'] . '</p></a>';
						   		echo '<tr>';
                  echo '<td>';
                  if ($asset['images']) {
                    echo '<img class="asset-image-table" src="data:image/png;base64,'. $asset['images'] . '"/>';
                  }
                  echo '</td>';
							   	echo '<td>'. $asset['asset_id'] . '</td>';
							   	echo '<td>'. $asset['name'] . '</td>';
							   	echo '<td>'. $asset['description'] . '</td>';
							   	echo '<td>'. $asset['type_value'] . '</td>';
							   	echo '<td>'. $asset['longitude'] . '<br>' . $asset['latitude'] . '</td>';
							   	echo '<td>'. $asset['created_by'] . '</td>';
							   	//echo '<td width=250>';
                  echo '<td></td>';
                  echo '<td></td>';/*
							   	echo '<a class="btn btn-default" href="read.php?asset_id='.$asset['asset_id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?asset_id='.$asset['asset_id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?asset_id='.$asset['asset_id'].'">Delete</a>';
							   	*///echo '</td>';
							   	echo '</tr>';
                 }
					   }
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->

<?php include_once 'footer.php'; ?>
