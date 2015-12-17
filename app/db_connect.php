<?php
class DB_Connect {
 
    private static $cont  = null;

    public function __construct() {
        exit('Init function is not allowed');
    }
    
    public static function connect() {      
        require_once '../config.php';

       // One connection through whole application
       if ( null == self::$cont ) {      
          try {
          self::$cont =  new PDO( "mysql:host=".DB_HOST.";"."dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);  
          }
          catch(PDOException $e) {
            die($e->getMessage());  
          }
       } 
       return self::$cont;
    }
    
    public static function disconnect() {
        self::$cont = null;
    }
 
} 
?>