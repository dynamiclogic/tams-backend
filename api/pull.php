<?php
//if password is test use test db
//send password only first, after success send the data

include_once './db_functions.php';
include_once './config.php';

//Create Object for DB_Functions clas
$db = new DB_Functions(); 

//Get JSON posted by Android Application
//$jsonAssets = $_POST["assetsJSON"];
$apiPassword = $_POST[_API_AUTH_POST];

//Remove Slashes
//$jsonAssets = stripslashes($jsonAssets);
//Decode JSON into an Array
//$data = json_decode($jsonAssets);

//Util arrays to create response JSON
$a=array();
$b=array();

//Loop through an Array and insert data read from JSON into MySQL DB
//for($i=0; $i<count($data) ; $i++) {

	//if ($data[$i]->deleted != 1) {
		//get asset from MySQL DB
	$assets = $db->getAllAssets();
	//}

//error_log($assets);
	//Based on inserttion, create JSON response
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

			array_push($a,$b);
		}
		//Post JSON response back to Android Application
	}

//}
		echo json_encode($a);
		error_log("PULL SERVER RESPONCE: ".json_encode($a),0);


?>
