<?php
class DB_Functions {

    private static $pdo = null;

    // constructor
    function __construct() {
        require_once 'db_connect.php';
        require_once 'config.php';
        // connecting to database
        self::$pdo = DB_Connect::connect();
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    // destructor
    function __destruct() {
        DB_Connect::disconnect();
    }

    /**
     * Storing new asset
     */
    public function addAsset($name='',$description='',$latitude='',$longitude='',$images='') {
        //ASSET
        $assetSql = "INSERT INTO assets (name,description) values(?, ?)";
        $assetQuery = self::$pdo->prepare($assetSql);
        $assetQuery->execute(array($name,$description));

        //LOCATION
        /* get last inserted auto_increment id */
        $asset_id = self::$pdo->lastInsertId();
        $locationSql = "INSERT INTO locations (asset_id, latitude, longitude) values(?, ?, ?)";
        $locationQuery = self::$pdo->prepare($locationSql);
        $locationQuery->execute(array($asset_id, $latitude, $longitude));

        //MEDIA
        $mediaSql = "INSERT INTO media (asset_id, images, voice_memo) values(?, ?, ?)";
        $mediaQuery = self::$pdo->prepare($mediaSql);
        $mediaQuery->execute(array($asset_id, $images, $voice_memo));
    }

    /**
     * Mark asset as deleted
     * 
     */
    public function deleteAsset($asset_id) {
        // delete data
        $sql = "UPDATE assets SET deleted = 1 WHERE asset_id = ?";
        $q = self::$pdo->prepare($sql);
        $q->execute(array($asset_id));
    }

    /**
     * Update Asset
     */
    public function updateAsset($asset_id,$name, $description) {
        $sql = "UPDATE assets  set name = ?, description = ? WHERE asset_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name,$description,$asset_id));
    }

    /**
     * Getting all active assets
     */
    public function getActiveAssets() {
        $sql = 'SELECT assets.*,
                    locations.longitude,
                    locations.latitude,
                    asset_types.type_value,
                    media.images
                FROM assets
                    LEFT JOIN asset_types ON assets.type_id = asset_types.asset_type_id
                    LEFT JOIN media ON assets.asset_id = media.asset_id
                    LEFT JOIN locations ON assets.asset_id = locations.asset_id
                WHERE deleted = 0
                    ORDER BY assets.asset_id DESC';
        return self::$pdo->query($sql);
    }

    /**
     * Getting asset by id
     */
    public function getAssetById($asset_id) {
        $sql = 'SELECT assets.*,
                    attributes.attribute_label,
                    attributes_values.attribute_value,
                    locations.longitude,
                    locations.latitude,
                    asset_types.type_value,
                    media.images,
                    media.voice_memo
                FROM assets 
                    LEFT JOIN asset_types ON assets.type_id = asset_types.asset_type_id
                    LEFT JOIN attributes_indexes ON assets.asset_id = attributes_indexes.asset_id
                    LEFT JOIN attributes ON attributes_indexes.attribute_id = attributes.attribute_id
                    LEFT JOIN attributes_values ON attributes_indexes.attribute_value_id = attributes_values.attribute_value_id
                    LEFT JOIN media ON assets.asset_id = media.asset_id
                    LEFT JOIN locations ON assets.asset_id = locations.asset_id
                WHERE (assets.asset_id = ?)';
        $q = self::$pdo->prepare($sql);
        $q->execute(array($asset_id));
        
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Delete User
     */
    public function deleteUser($user_id) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $q = self::$pdo->prepare($sql);
        $q->execute(array($user_id));
    }

    /**
     * Get All Users
     */
    public function getAllUsers() {
        $sql = 'SELECT * FROM users ORDER BY user_id DESC';
        return self::$pdo->query($sql);
    }
}

?>