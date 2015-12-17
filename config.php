<?php
/**
 * DB configuration variables
 */
define("DB_HOST", "localhost");
define("DB_USER", "tams");
define("DB_PASSWORD", "tams");
define("DB_DATABASE", "tams");


# DO NOT TOUCH ANYTHING BELLOW THIS LINE
# -------------------------------------#
// Tables
define("_ASSETS_TABLE", "assets"); 
define("_LOCATIONS_TABLE", "locations"); 
define("_MEDIA_TABLE", "media"); 
define("_ATTRIBUTES_TABLE", "attributes"); 
define("_ATTRIBUTES_INDEXES_TABLE", "attributes_indexes"); 
define("_ATTRIBUTES_VALUES_TABLE", "attributes_values"); 
define("_ASSET_TYPES_TABLE", "asset_types_table");
define("_API_AUTH_TABLE", "api_auth");

// Table columns
//Asset table columns
define("_ASSETS_COLUMN_ASSET_ID", "asset_id"); 
define("_ASSETS_COLUMN_CREATED_AT", "created_at");
define("_ASSETS_COLUMN_UPDATED_AT", "updated_at"); 
define("_ASSETS_COLUMN_ASSET_NAME", "name");
define("_ASSETS_COLUMN_ASSET_DESCRIPTION", "description"); 
define("_ASSETS_COLUMN_NEEDSSYNC", "needsSync");  //used in app only
define("_ASSETS_COLUMN_DELETED", "deleted"); 
define("_ASSETS_COLUMN_ISNEW", "isNew");  //used in app only - keeps track if the asset is brand new - useful for server function call
    //Locations table columns
define("_LOCATIONS_COLUMN_LOCATION_ID", "location_id"); 
define("_LOCATIONS_COLUMN_ASSET_ID", "asset_id"); 
define("_LOCATIONS_COLUMN_LONGITUDE", "longitude"); 
define("_LOCATIONS_COLUMN_LATITUDE", "latitude"); 
    //Media table columns
define("_MEDIA_COLUMN_MEDIA_ID", "media_id"); 
define("_MEDIA_COLUMN_ASSET_ID", "asset_id"); 
define("_MEDIA_COLUMN_IMAGES", "images"); 
define("_MEDIA_COLUMN_VOICE_MEMO", "voice_memo"); 
    //Asset types table columns
define("_ASSET_TYPES_ASSET_TYPE_ID", "asset_type_id"); 
define("_ASSET_TYPES_TYPE_VALUE", "type_value"); 
    //Attributes table columns
define("_ATTRIBUTES_ATTRIBUTE_ID", "attribute_id"); 
define("_ATTRIBUTES_ATTRIBUTE_LABEL", "attribute_label"); 
    //Attributes indexes columns
define("_ATTRIBUTES_INDEXES_ATTRIBUTE_INDEX_ID", "attribute_index_id"); 
define("_ATTRIBUTES_INDEXES_ASSET_ID", "asset_id"); 
define("_ATTRIBUTES_INDEXES_ATTRIBUTE_ID", "attrubute_id"); 
define("_ATTRIBUTES_INDEXES_ATTRIBUTE_VALUE_ID", "attribute_value_id"); 
    //Atributes values columns
define("_ATTRIBUTES_VALUES_ATTRIBUTE_VALUE_ID", "attribute_value_id"); 
define("_ATTRIBUTES_VALUES_ATTRIBUTE_VALUE", "attribute_value"); 
define("_ATTRIBUTES_VALUES_ATTRIBUTE_ID", "attribute_id"); 
	//Api Auth columns
define("_API_AUTH_API_AUTH_ID","api_auth_id");
define("_API_AUTH_KEY","key");
define("_API_AUTH_PRACTICE","practice");

//post requests
define("_API_AUTH_POST", "apiAuth");
define("_ASSETS_JSON_POST", "asset");

/* Skin */
if (!defined ('skin')) {
	define('skin', '../skin/default/');
}
?>