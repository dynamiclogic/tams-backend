<?php
class DB_Functions {

    private static $pdo = null;

    // constructor
    function __construct() {
        require_once 'db_connect.php';
        require_once '../config.php';
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
        $assetSql = "INSERT INTO assets (asset_id,name,description,created_at,updated_at) values(?, ?, ?, ?, ?)";
        $assetQuery = self::$pdo->prepare($assetSql);
        $assetQuery->execute(array(time(),$name,$description,time(),time()));

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
        $sql = "UPDATE assets SET deleted = 1, updated_at = ".time()." WHERE asset_id = ?";
        $q = self::$pdo->prepare($sql);
        $q->execute(array($asset_id));
    }

    /**
     * Undelete asset
     * 
     */
    public function undeleteAsset($asset_id) {
        // delete data
        $sql = "UPDATE assets SET deleted = 0, updated_at = ".time()." WHERE asset_id = ?";
        $q = self::$pdo->prepare($sql);
        $q->execute(array($asset_id));
    }

    /**
     * Purge User
     */
    public function purgeAsset($asset_id) {
        $sql = "DELETE FROM assets WHERE asset_id = ?";
        $q = self::$pdo->prepare($sql);
        $q->execute(array($asset_id));
    }

    /**
     * Update Asset
     */
    public function updateAsset($asset_id,$name, $description) {
        $sql = "UPDATE assets set name = ?, description = ?, updated_at = ? WHERE asset_id = ?";
        $q = self::$pdo->prepare($sql);
        $q->execute(array($name,$description,time(),$asset_id));
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
     * Getting all active assets
     */
    public function getDeletedAssets() {
        $sql = 'SELECT assets.*,
                    locations.longitude,
                    locations.latitude,
                    asset_types.type_value,
                    media.images
                FROM assets
                    LEFT JOIN asset_types ON assets.type_id = asset_types.asset_type_id
                    LEFT JOIN media ON assets.asset_id = media.asset_id
                    LEFT JOIN locations ON assets.asset_id = locations.asset_id
                WHERE deleted = 1
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

    // Start Paging
    public function paging($query,$records_per_page) {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
            $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $sql=$query." limit $starting_position,$records_per_page";
        return $sql;
    }
    
    public function paginglink($query,$records_per_page) {
        
        $self = $_SERVER['PHP_SELF'];
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $total_no_of_records = $stmt->rowCount();
        
        if($total_no_of_records > 0)
        {
            ?><ul class="pagination"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
                $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous =$current_page-1;
                echo "<li><a href='".$self."?page_no=1'>First</a></li>";
                echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
                }
                else
                {
                    echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
                echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
            }
            ?></ul><?php
        }
    }
    // End Paging
}

?>