<?php
include_once './db_functions.php';
include_once '../../config.php';

class DeleteAsset {
	public function processDeleteAsset($data) {
		error_log("DELETE STARTED");
		//Create Object for DB_Functions clas
		$db = new DB_Functions(); 
		
		//Util arrays to create response JSON
		$a=array();
		$b=array();
				
		//Loop through an Array and insert data read from JSON into MySQL DB
		for($i=0; $i<count($data) ; $i++) {

			if (isset($data[$i]->asset_id) && isset($data[$i]->updated_at)) {
				$query = $db->deleteAsset($data[$i]->asset_id, 
										  $data[$i]->updated_at);
			}
			else {
				return "asset_id & updated_at is Required";
			}

			//Based on inserttion, create JSON response to set the asset flags
			if($query) { //if success
				$b[_ASSETS_COLUMN_ASSET_ID] = $data[$i]->asset_id;
				$b[_ASSETS_COLUMN_NEEDSSYNC] = 0;
				$b["purgeAsset"] = 1; //if asset was successfully deleted, purged from client
				$b["error"] = 0; //return 0 if success
				array_push($a,$b);
			} else {	//if insert failed
				$b[_ASSETS_COLUMN_ASSET_ID] = $data[$i]->asset_id;
				$b[_ASSETS_COLUMN_NEEDSSYNC] = 1;
				$b["purgeAsset"] = 0;
				$b["error"] = 1; //return 1 if fail
				array_push($a,$b);
			}
		}
		//Post JSON response back to Android Application
		error_log("DELETE ENDED");

		return $a;
		//error_log("PUSH SERVER RESPONSE: ".json_encode($a),0);
	}
}
?>
