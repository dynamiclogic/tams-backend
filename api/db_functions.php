<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        include_once './config.php';
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
    public function addAsset($asset_id='',$name='',$description='',$created_at='',$updated_at='',$deleted='',$latitude='',$longitude='',$images='') {
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
        $locationQuery = "INSERT INTO " ._LOCATIONS_TABLE. " ("._LOCATIONS_COLUMN_ASSET_ID.", "
                                                  ._LOCATIONS_COLUMN_LATITUDE.", "
                                                  ._LOCATIONS_COLUMN_LONGITUDE.")
                                VALUES('$asset_id','$latitude','$longitude')";
        $mediaQuery = "INSERT INTO " ._MEDIA_TABLE. " ("._MEDIA_COLUMN_ASSET_ID.", "
                                                  ._MEDIA_COLUMN_IMAGES.")
                                VALUES('$asset_id','$images')";
        $assetResult = mysql_query($assetQuery);
        if($assetResult) {
            $locationResult = mysql_query($locationQuery);
            $mediaResult = mysql_query($mediaQuery);
        }
    
        //error_log($query);
        
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
    public function deleteAsset($asset_id) {
        //Insert user into database
        //$timestamp = time();
        $deleted = 1;
        $result = mysql_query("UPDATE assets SET deleted = '$deleted' 
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
    public function updateAsset($asset_id='',$name='',$description='',$created_at='',$updated_at='',$deleted='',$latitude='',$longitude='',$images='') {
        //Insert user into database
        //$timestamp = time();
        $assetQuery = "UPDATE assets SET " ._ASSETS_COLUMN_ASSET_NAME. " = '$name'," 
                                     ._ASSETS_COLUMN_ASSET_DESCRIPTION. " = '$description'," 
                                     ._ASSETS_COLUMN_CREATED_AT. "= '$created_at'," 
                                     ._ASSETS_COLUMN_UPDATED_AT. "= '$updated_at'," 
                                     ._ASSETS_COLUMN_DELETED. "= '$deleted' 
                                WHERE "
                                     ._ASSETS_COLUMN_ASSET_ID. "= '$asset_id' ";
        $locationQuery = "UPDATE "._LOCATIONS_TABLE." SET " ._LOCATIONS_COLUMN_LATITUDE. " = '$latitude'," 
                                     ._LOCATIONS_COLUMN_LONGITUDE. "= '$longitude'
                                WHERE "
                                     ._LOCATIONS_COLUMN_ASSET_ID. "= '$asset_id' ";
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
                LEFT JOIN '._MEDIA_TABLE.' ON '._ASSETS_TABLE.'.'._ASSETS_COLUMN_ASSET_ID.' = '._MEDIA_TABLE.'.'._MEDIA_COLUMN_ASSET_ID;
;
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