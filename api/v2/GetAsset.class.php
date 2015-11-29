<?php
include_once './db_functions.php';
include_once './config.php';

class GetAsset {
	public function processGetAsset($asset_id = null) {
		error_log("GET STARTED");
		//Create Object for DB_Functions clas
		$db = new DB_Functions(); 
		
		//Util arrays to create response JSON
		$a=array();
		$b=array();

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
		
		//error_log($assets);
		if($assets != false) { //if success
			$no_of_assets = mysql_num_rows($assets);
			while ($row = mysql_fetch_array($assets)) {
				$b[_ASSETS_COLUMN_ASSET_NAME] = $row[_ASSETS_COLUMN_ASSET_NAME];
				$b[_ASSETS_COLUMN_ASSET_DESCRIPTION] = $row[_ASSETS_COLUMN_ASSET_DESCRIPTION];
				$b[_ASSETS_COLUMN_ASSET_ID] = $row[_ASSETS_COLUMN_ASSET_ID];
				$b[_ASSETS_COLUMN_NEEDSSYNC] = 0; //asset does not need sync any more
				$b[_ASSETS_COLUMN_ISNEW] = 0; //mark the asset as NOT new
				$b[_ASSETS_COLUMN_DELETED] = $row[_ASSETS_COLUMN_DELETED];
				$b[_ASSETS_COLUMN_CREATED_AT] = $row[_ASSETS_COLUMN_CREATED_AT];
				$b[_ASSETS_COLUMN_UPDATED_AT] = $row[_ASSETS_COLUMN_UPDATED_AT];
	
				// locations
				$b[_LOCATIONS_COLUMN_LONGITUDE] = 0;
				$b[_LOCATIONS_COLUMN_LATITUDE] = 0;
				if ($row[_LOCATIONS_COLUMN_LONGITUDE])
					$b[_LOCATIONS_COLUMN_LONGITUDE] = $row[_LOCATIONS_COLUMN_LONGITUDE];
				if ($row[_LOCATIONS_COLUMN_LATITUDE])
					$b[_LOCATIONS_COLUMN_LATITUDE] = $row[_LOCATIONS_COLUMN_LATITUDE];
	
				// media
				$b[_MEDIA_COLUMN_IMAGES] = "";
				if ($row[_MEDIA_COLUMN_IMAGES])
					$b[_MEDIA_COLUMN_IMAGES] = $row[_MEDIA_COLUMN_IMAGES];
	
				$b["purgeAllAssets"] = $purgeAllAssets;
				array_push($a,$b);
			}
		}
		//Post JSON response back to Application
		//		error_log("PULL SERVER RESPONCE: ".json_encode($a),0);

		error_log("GET ENDED");
		return $a;
	}
}
?>
