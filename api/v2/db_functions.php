<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        include_once '../../config.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * Storing new asset
     * returns asset details
     */
    public function addAsset($asset_id='',$name='',$description='',$created_at='',$updated_at='',$deleted='',$latitude='',$longitude='',$images='',$locations=null) {
        // Insert user into database
        //$timestamp = time();
        //$deleted = 0;
        $assetQuery = "INSERT INTO assets ("._ASSETS_COLUMN_ASSET_ID.", "
                                       ._ASSETS_COLUMN_ASSET_NAME.", "
                                       ._ASSETS_COLUMN_ASSET_DESCRIPTION.", "
                                       ._ASSETS_COLUMN_CREATED_AT.", "
                                       ._ASSETS_COLUMN_UPDATED_AT.", "
                                       ._ASSETS_COLUMN_DELETED.")
                               VALUES('$asset_id','$name','$description','$created_at','$updated_at','$deleted')";

        //if the location array is empty, just insert the one location
        if($locations == null) {
            $locationQuery = "INSERT INTO " ._LOCATIONS_TABLE. " ("._LOCATIONS_COLUMN_ASSET_ID.", "
                                                  ._LOCATIONS_COLUMN_LATITUDE.", "
                                                  ._LOCATIONS_COLUMN_LONGITUDE.")
                                VALUES('$asset_id','$latitude','$longitude')";
        } else {
            $locationQuery = "INSERT INTO " ._LOCATIONS_TABLE. " ("._LOCATIONS_COLUMN_ASSET_ID.", "
                                                  ._LOCATIONS_COLUMN_LATITUDE.", "
                                                  ._LOCATIONS_COLUMN_LONGITUDE.")
                                VALUES";
            $insertData = array();
            foreach ($locations as $location) {
                $insertData[] = "(";
                $insertData[] = $asset_id.",";
                $insertData[] = $location['latitude'].",";
                $insertData[] = $location['longitude'];
                $insertData[] = "),";
            }
            
            if (!empty($insertData)) {
                $locationQuery .= implode('', $insertData);
                $locationQuery = trim($locationQuery, ",");
            }
        }

        $mediaQuery = "INSERT INTO " ._MEDIA_TABLE. " ("._MEDIA_COLUMN_ASSET_ID.", "
                                                  ._MEDIA_COLUMN_IMAGES.")
                                VALUES('$asset_id','$images')";
        $assetResult = mysql_query($assetQuery);
        if($assetResult) {
            $locationResult = mysql_query($locationQuery);
            $mediaResult = mysql_query($mediaQuery);
        }
    
        //error_log($assetQuery);
        
        if ($assetResult && $locationResult && $mediaResult) {
            return true;
        } else {
            if( mysql_errno() == 1062) {
                // Duplicate key - Primary Key Violation
                return true;
            } else {
                // For other errors
                return false;
            }            
        }
    }

    /**
     * Mark asset as deleted
     * 
     */
    public function deleteAsset($asset_id, $updated_at) {
        //Insert user into database
        //$timestamp = time();
        $deleted = 1;
        $result = mysql_query("UPDATE assets SET deleted = '$deleted' ,
                                                 updated_at = '$updated_at' 
                                             WHERE asset_id = '$asset_id' ");
        
        if ($result) {
            return true;
        } else {
            if( mysql_errno() == 1062) {
                // Duplicate key - Primary Key Violation
                return true;
            } else {
                // For other errors
                return false;
            }            
        }
    }

    /**
     * Mark asset as deleted
     * 
     */
    public function updateAsset($asset_id='',$name='',$description='',$created_at='',$updated_at='',$deleted='',$latitude='',$longitude='',$images='',$locations=null) {
        //Insert user into database
        //$timestamp = time();
        $assetQuery = "UPDATE assets SET " ._ASSETS_COLUMN_ASSET_NAME. " = '$name'," 
                                     ._ASSETS_COLUMN_ASSET_DESCRIPTION. " = '$description'," 
                                     ._ASSETS_COLUMN_CREATED_AT. "= '$created_at'," 
                                     ._ASSETS_COLUMN_UPDATED_AT. "= '$updated_at'," 
                                     ._ASSETS_COLUMN_DELETED. "= '$deleted' 
                                WHERE "
                                     ._ASSETS_COLUMN_ASSET_ID. "= '$asset_id' ";

        //if the location array is empty, just insert the one location
        if($locations == null) {
            $locationQuery = "UPDATE "._LOCATIONS_TABLE." 
                                SET " ._LOCATIONS_COLUMN_LATITUDE. " = '$latitude'," 
                                      ._LOCATIONS_COLUMN_LONGITUDE. "= '$longitude'
                                WHERE "
                                     ._LOCATIONS_COLUMN_ASSET_ID. "= '$asset_id' ";

        } else {
            //delete the locations assosiated with the asset before updating
            $deleteLocations = "DELETE FROM " ._LOCATIONS_TABLE. " WHERE " ._LOCATIONS_COLUMN_ASSET_ID. "=" .$asset_id;
            mysql_query($deleteLocations);

            $locationQuery = "INSERT INTO " ._LOCATIONS_TABLE. " ("._LOCATIONS_COLUMN_ASSET_ID.", "
                                      ._LOCATIONS_COLUMN_LATITUDE.", "
                                      ._LOCATIONS_COLUMN_LONGITUDE.")
                                VALUES";

            $insertData = array();
            foreach ($locations as $location) {
                $insertData[] = "(";
                $insertData[] = $asset_id.",";
                $insertData[] = $location['latitude'].",";
                $insertData[] = $location['longitude'];
                $insertData[] = "),";
            }
            
            if (!empty($insertData)) {
                $locationQuery .= implode('', $insertData);
                $locationQuery = trim($locationQuery, ",");
            }
        }

        $mediaQuery = "UPDATE "._MEDIA_TABLE." SET " ._MEDIA_COLUMN_IMAGES. " = '$images'
                                WHERE "
                                     ._MEDIA_COLUMN_ASSET_ID. "= '$asset_id' ";
        //error_log($query);
        $assetResult = mysql_query($assetQuery);
        if ($assetResult) {
            $locationResult = mysql_query($locationQuery);
            $mediaResult = mysql_query($mediaQuery);
        }
        
        if ($assetResult && $locationResult && $mediaResult) {
            return true;
        } else {
            if( mysql_errno() == 1062) {
                // Duplicate key - Primary Key Violation
                return true;
            } else {
                // For other errors
                return false;
            }            
        }
    }

    /**
     * Getting all assets
     */
    public function getAllAssets() {
        $sql = 'SELECT '._ASSETS_TABLE.'.*,
                       '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_LONGITUDE.',
                       '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_LATITUDE.',
                       '._MEDIA_TABLE.'.'._MEDIA_COLUMN_IMAGES.'
                FROM '._ASSETS_TABLE.' 
                LEFT JOIN '._LOCATIONS_TABLE.' ON '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_ASSET_ID.'
                LEFT JOIN '._MEDIA_TABLE.' ON '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '._MEDIA_TABLE.'.'._MEDIA_COLUMN_ASSET_ID.'
                ORDER BY ' ._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID;
        
        $result = mysql_query($sql);
        return $result;
    }

    /**
     * Get location
     */
    public function getLocationsByAssetId($asset_id) {
        $query = 'SELECT '._LOCATIONS_COLUMN_LONGITUDE.',
                          '._LOCATIONS_COLUMN_LATITUDE.'
                   FROM '._LOCATIONS_TABLE.'
                   WHERE '._ASSETS_COLUMN_ASSET_ID.' = '.$asset_id.' 
                   ORDER BY '._LOCATIONS_COLUMN_LOCATION_ID.' ASC' ;
        $result = mysql_query($query);
        return $result;
    }

    /**
     * Execute SQL Query
     */
    public function executeSqlQuery($query) {
        $result = mysql_query($query) or die(mysql_error());
        return $result;
    }

    /**
     * Getting asset by id 
     */
    public function getAssetById($asset_id) {
        $sql = 'SELECT '._ASSETS_TABLE.'.*,
                       '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_LONGITUDE.',
                       '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_LATITUDE.',
                       '._MEDIA_TABLE.'.'._MEDIA_COLUMN_IMAGES.'
                FROM '._ASSETS_TABLE.' 
                LEFT JOIN '._LOCATIONS_TABLE.' ON '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_ASSET_ID.'
                LEFT JOIN '._MEDIA_TABLE.' ON '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '._MEDIA_TABLE.'.'._MEDIA_COLUMN_ASSET_ID.'
                WHERE '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '.$asset_id;
        $result = mysql_query($sql);
        return $result;
    }

        /**
     * Getting all active assets
     */
    public function getAllActiveAssets() {
        $sql = 'SELECT '._ASSETS_TABLE.'.*,
                       '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_LONGITUDE.',
                       '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_LATITUDE.',
                       '._MEDIA_TABLE.'.'._MEDIA_COLUMN_IMAGES.'
                FROM '._ASSETS_TABLE.' 
                LEFT JOIN '._LOCATIONS_TABLE.' ON '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '._LOCATIONS_TABLE.'.'._LOCATIONS_COLUMN_ASSET_ID.'
                LEFT JOIN '._MEDIA_TABLE.' ON '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '._MEDIA_TABLE.'.'._MEDIA_COLUMN_ASSET_ID.
                ' WHERE '._ASSETS_COLUMN_DELETED. ' = 0
                ORDER BY '._ASSETS_COLUMN_ASSET_ID.' DESC';
        $result = mysql_query($sql);
        return $result;
    }
}

?>