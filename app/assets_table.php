<?php
include "../config.php";
include "db_functions.php";
session_start();
if(empty($_SESSION['login_user']))
{
header('Location: index.php');
}

?>

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
		<div class="asset-mobile-description">
			<h4 class="list-group-item-heading">
				<?php print($asset['name']); ?>
			</h4>
			<p class="list-group-item-text"> <?php print($asset['description'])?> </p>
		</div>
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
	   	<td><?php print($asset['latitude'])?></td>
	   	<td><?php print($asset['longitude'])?></td>
	   	<td><?php print($asset['created_by'])?></td>
        <td><?php print(date('Y-m-d h:i:s',$asset['updated_at']))?></td>
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