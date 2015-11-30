<?php
//if password is test use test db
//send password only first, after success send the data

include_once './db_functions.php';
include_once './config.php';

class CreateAsset {
	public function processCreate($data) {
		error_log("CREATE STARTED");
		//Create Object for DB_Functions clas
		$db = new DB_Functions(); 
		
		//Get JSON posted by Android Application
		//$jsonAssets = $_POST[_ASSETS_JSON_POST];
		//$apiPassword = $_POST[_API_AUTH_POST];
		
		//Remove Slashes
		//$jsonAssets = stripslashes($jsonAssets);
		//Decode JSON into an Array
		//$data = json_decode($jsonAssets);
		//error_log("PUSH SERVER RECEIVED: ".$data,0);
		//error_log($apiPassword,0);
		
		//Util arrays to create response JSON
		$a=array();
		$b=array();
		
		$purgeAsset = 0;
		
		//Loop through an Array and insert data read from JSON into MySQL DB
		for($i=0; $i<count($data) ; $i++) {
		
			$asset_id = $asset_name = $asset_description = $asset_created_at = $asset_updated_at = "";
			$asset_deleted = $asset_latitude = $asset_longitude = $asset_images= "";
			if (isset($data[$i]->asset_id))
				$asset_id = $data[$i]->asset_id;
			if (isset($data[$i]->name))
				$asset_name = $data[$i]->name;
			if (isset($data[$i]->description))
				$asset_description = $data[$i]->description;
			if (isset($data[$i]->created_at))
				$asset_created_at = $data[$i]->created_at;
			if (isset($data[$i]->updated_at))
				$asset_updated_at = $data[$i]->updated_at;
			if (isset($data[$i]->deleted))
				$asset_deleted = $data[$i]->deleted;
			if (isset($data[$i]->latitude))
				$asset_latitude = $data[$i]->latitude;
			if (isset($data[$i]->longitude))
				$asset_longitude = $data[$i]->longitude;
			if (isset($data[$i]->images))
				$asset_images = $data[$i]->images;
		
			if ($data[$i]->isNew == 1) {
				//Store User into MySQL DB
				$query = $db->addAsset($asset_id,
									   $asset_name,
									   $asset_description,
									   $asset_created_at,
									   $asset_updated_at,
									   $asset_deleted,
									   $asset_latitude,
									   $asset_longitude,
									   $asset_images);
			} else {
				return "Asset not new";
			}
			//Based on inserttion, create JSON response to set the asset flags
			if($query) { //if success
				$b[_ASSETS_COLUMN_ASSET_ID] = $data[$i]->asset_id;
				$b[_ASSETS_COLUMN_NEEDSSYNC] = 0; //asset does not need sync any more
				$b[_ASSETS_COLUMN_ISNEW] = 0; //mark the asset as NOT new
				$b["error"] = 0; //return 0 if success
				array_push($a,$b);
			} else {	//if insert failed
				$b[_ASSETS_COLUMN_ASSET_ID] = $data[$i]->asset_id;
				$b[_ASSETS_COLUMN_NEEDSSYNC] = 1;
				$b[_ASSETS_COLUMN_ISNEW] = 0; //mark the asset as NOT new
				$b["error"] = 1; //return 1 if fail
				array_push($a,$b);
			}
		}
		//Post JSON response back to Android Application
				//error_log("PUSH SERVER RESPONSE: ".json_encode($a),0);
		error_log("CREATE ENDED");
		return $a;
	}
}
?>
