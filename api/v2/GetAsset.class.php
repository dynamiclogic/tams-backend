<?php
include_once './db_functions.php';
include_once '../../config.php';

class GetAsset {
	public function processGetAsset($asset_id = null) {
		error_log("GET STARTED");
		//Create Object for DB_Functions clas
		$db = new DB_Functions(); 
		
		//Util arrays to create response JSON
		$a=array();
		$b=array();
		$parent = array();

		$purgeAllAssets = 0;  //purge all
		if ($purgeAllAssets) {
			$b["purgeAllAssets"] = $purgeAllAssets;
			array_push($a,$b);
			return $a;
		}


		if ($asset_id == null) {
			$assets = $db->getAllAssets();
		}
		else {
			$assets = $db->getAssetById($asset_id);
		}

		while($row = mysql_fetch_assoc($assets))
		{   

		    //$parent[$row['asset_id']]= array("asset_id"=>$row['asset_id'],"name"=>$row['name']);
		    $parent = $row;
		    $parent[_ASSETS_COLUMN_NEEDSSYNC] = 0;
		    $parent[_ASSETS_COLUMN_ISNEW] = 0;
		    $parent["purgeAllAssets"] = $purgeAllAssets;
		
		    $result1 = $db->getLocationsByAssetId($row[_ASSETS_COLUMN_ASSET_ID]);
		
		    while($row1 = mysql_fetch_array($result1)) {
		        $parent["locations"][] = array(_LOCATIONS_COLUMN_LATITUDE=>$row1[_LOCATIONS_COLUMN_LATITUDE],
		        															  _LOCATIONS_COLUMN_LONGITUDE=>$row1[_LOCATIONS_COLUMN_LONGITUDE]);
		    }
		    array_push($a, $parent);
		}
		error_log("GET ENDED");
		return $a;
	}
}
?>
