<?php
include "config.php";

class Database 
{	
	private static $cont  = null;
	private static $host = "localhost";
	private static $database = "tams";
	private static $username = "tams";
	private static $password = "tams";

	public function __construct() {
		exit('Init function is not allowed');
	}
	
	public static function connect()
	{
		global $config;

	   // One connection through whole application
       if ( null == self::$cont )
       {      
        try 
        {
          self::$cont =  new PDO( "mysql:host=".self::$host.";"."dbname=".self::$database, self::$username, self::$password);  
        }
        catch(PDOException $e) 
        {
          die($e->getMessage());  
        }
       } 
       return self::$cont;
	}
	
	public static function disconnect()
	{
		self::$cont = null;
	}
}
?>